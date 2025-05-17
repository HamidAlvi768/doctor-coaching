<?php

namespace app\controllers;

use app\components\Helper;
use app\components\Mail;
use app\models\Answer;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\News;
use app\models\SignupForm;
use app\models\Session;
use app\models\UserImages;
use yii\web\UploadedFile;
use app\models\User; // Ensure you have the User model imported
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use app\models\Quiz;
use app\models\Question;
use app\models\QuizTimeLog;
use app\models\Reattempts;
use app\models\Stream;
use app\models\StudentResponse;
use app\models\StudentSessionAssignment;
use app\models\Video;
use yii\data\ArrayDataProvider;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $actionId = $action->id;
        $verificationId = 'verify-otp';

        // Check if the user is logged in
        if (!Yii::$app->user->isGuest) {
            if (Helper::checkTimeAndLogout()) {
                return Yii::$app->response->redirect(["site/login"]);
            }
            $user = Yii::$app->user->identity;

            // If OTP is not verified, redirect the user to the OTP verification page
            if ($user && empty($user->email_verified) && $actionId !== $verificationId) {
                Yii::$app->response->redirect(["site/$verificationId"]);
                return false;  // Prevent further action execution
            }
        }

        // If the user is not logged in or OTP is verified, proceed with the action
        return parent::beforeAction($action);
    }


    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    // public function actionAttemptquiz()
    // {

    //     return $this->render('signup', [
    //         'model' => $model,
    //     ]);
    // }

    //     public function actionSignup()
    // {
    //     $model = new SignupForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->signup()) {
    //         Yii::$app->session->setFlash('success', 'Thank you for registering. Please login.');
    //         return $this->redirect(['login']);
    //     }

    //     return $this->render('signup', [
    //         'model' => $model,
    //     ]);
    // }


    public function actionSignup()
    {
        $model = new SignupForm();
        $sessions = Session::find()->all(); // Fetch all sessions from the sessions table
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                // echo"<pre>"; var_dump($model->full_name); exit;
                // Save selected sessions as comma-separated values
                // $selectedSessions = Yii::$app->request->post('SignupForm')['register_for'] ?? null;
                // if ($selectedSessions) {
                //     $model->register_for = implode(',', $selectedSessions);
                // } else {
                //     Yii::$app->session->setFlash('danger', 'sessions are required');
                // }
                // Check if register_for exists in the POST data
                $selectedSessions = isset(Yii::$app->request->post('SignupForm')['register_for']) ?
                    Yii::$app->request->post('SignupForm')['register_for'] : null;

                // Validate sessions
                if (is_array($selectedSessions) && !empty($selectedSessions)) {
                    if ($user = $model->signup()) {
                        Mail::SendVerificationMail($user);
                        $loginForm = new LoginForm();
                        $loginForm->username = $model->email;
                        $loginForm->password = $model->password;
                        if ($loginForm->login()) {
                            $user = User::findOne(Yii::$app->user->identity->id);
                            $user->timeout = Helper::expireTime(86400); // 86400 seconds = 24 hours  
                            $user->last_user_agent = Yii::$app->request->userAgent;
                            $user->ip = Yii::$app->request->userIP;
                            $user->session_id = Yii::$app->session->getId();
                            $user->login_time = Helper::expireTime(0);
                            $user->save();
                            
                            if (Yii::$app->user->identity->usertype == 'admin') {
                                return $this->redirect(['site/adminpanel']);
                            }
                            if (Yii::$app->user->identity->usertype == 'student') {
                                return $this->redirect(['site/dashboard']); 
                            }
                        }
                        Yii::$app->session->setFlash('success', 'Thank you for registering. Please login.');
                        return $this->redirect(['login']);
                    }
                } else {
                    Yii::$app->session->setFlash('danger', 'At least one session is required.');
                }
                // var_dump($model->register_for); exit;
            }
        }

        return $this->render('signup', [
            'model' => $model,
            'sessions' => $sessions, // Pass sessions to the view
        ]);
    }

    public function actionVerifyOtp()
    {
        $user = User::find()->where(['email' => Yii::$app->user->identity->email])->one();

        $newOtop = Yii::$app->request->get("otp");
        if ($newOtop) {
            $user->otp = Helper::generateOtpWithExpiry()['otp'];
            $user->otp_expire = Helper::generateOtpWithExpiry()['expiry'];
            $user->save();
            Mail::SendVerificationMail($user);
            // OTP is valid
            Yii::$app->session->setFlash('success', 'New OTP submit on your email!');
            Yii::$app->response->redirect(['site/verify-otp']);
        }

        // Handle form submission
        if (Yii::$app->request->isPost) {
            $userOtp = Yii::$app->request->post('otp'); // OTP entered by user

            $_otp = "";
            for ($i = 0; $i < count($userOtp); $i++) {
                $_otp .= $userOtp[$i];
            }

            // Check if OTP is correct and not expired
            if ($_otp == $user->otp) {
                $currentTime = date('Y-m-d H:i:s');
                if (strtotime($currentTime) > strtotime($user->otp_expire)) {
                    Yii::$app->session->setFlash('error', 'OTP has expired.');
                } else {
                    $user->email_verified = $currentTime;
                    $user->save();
                    // Yii::$app->response->redirect(['site/dashboard']);

                    // OTP is valid
                    Yii::$app->session->setFlash('success', 'Email & OTP verified successfully!');
                    return $this->redirect(['site/dashboard']); // Redirect to another page after successful verification
                }
            } else {
                Yii::$app->session->setFlash('error', 'Invalid OTP.');
            }
        }

        // Render OTP verification form
        return $this->render('verify-otp');
    }

    private function assignDemoSessions()
    {
        $loggedInUserId = Yii::$app->user->identity->id;
        $role = Yii::$app->user->identity->usertype;

        if ($role == "student") {
            // Fetch sessions where the type is 'demo' and they are not assigned to the logged-in user
            $availableSessions = Session::find()
                ->alias('s')  // Set alias for sessions table
                ->leftJoin('student_session_assignment ssa', 'ssa.session_id = s.id AND ssa.student_id = :userId', [':userId' => $loggedInUserId])
                ->where(['s.type' => 'demo'])  // Fetch only demo sessions
                ->andWhere(['ssa.session_id' => null])  // Exclude sessions that are already assigned
                ->all();

            foreach ($availableSessions as $key => $session) {
                $assign = new StudentSessionAssignment();
                $assign->student_id = $loggedInUserId;
                $assign->session_id = $session->id;
                $assign->save();
            }
        }
    }


    public function actionAttemptedQuiz()
    {
        $this->layout = "student_layout";

        // Ensure the user is logged in
        if (Yii::$app->user->isGuest) {
            throw new \yii\web\ForbiddenHttpException('You must be logged in to view attempted quizzes.');
        }

        $studentId = Yii::$app->user->identity->id;

        // Fetch attempted quizzes with relations using joins
        $attemptedQuizzes = StudentResponse::find()
            ->select([
                'student_response.*',
                'quiz.title AS quiz_title',
                'quiz.description AS quiz_description',
                'quiz.start_at AS quiz_start_at',
                'quiz.end_at AS quiz_end_at',
                'quiz.duration_in_minutes AS quiz_duration',
                'session.name AS session_name',
                'session.description AS session_description',
                'session.start_time AS session_start_time',
                'session.end_time AS session_end_time',
                'question.question_text AS question_text',
                'question.type AS question_type',
                'question.qnumber AS question_number',
            ])
            ->where(['student_response.student_id' => $studentId])
            ->joinWith([
                'quiz' => function ($query) {
                    $query->from('quiz');
                },
                'session' => function ($query) {
                    $query->from('session');
                },
                'question' => function ($query) {
                    $query->from('question')->joinWith(['answers']);
                },
            ], true) // Eager loading
            ->orderBy(['student_response.submitted_at' => SORT_DESC]) // Latest first
            ->all();

        // Structure the data for the view
        $quizData = [];
        foreach ($attemptedQuizzes as $response) {
            $quizId = $response->quiz_id;
            if (!isset($quizData[$quizId])) {
                $quizData[$quizId] = [
                    'quiz' => [
                        'id' => $response->quiz->id,
                        'title' => $response->quiz->title,
                        'description' => $response->quiz->description,
                        'start_at' => $response->quiz->start_at,
                        'end_at' => $response->quiz->end_at,
                        'duration_in_minutes' => $response->quiz->duration_in_minutes,
                    ],
                    'session' => [
                        'id' => $response->session->id,
                        'name' => $response->session->name,
                        'description' => $response->session->description,
                        'start_time' => $response->session->start_time,
                        'end_time' => $response->session->end_time,
                    ],
                    'questions' => [],
                ];
            }

            $questionId = $response->question_id;
            if (!isset($quizData[$quizId]['questions'][$questionId])) {
                $quizData[$quizId]['questions'][$questionId] = [
                    'id' => $response->question->id,
                    'qnumber' => $response->question->qnumber,
                    'question_text' => $response->question->question_text,
                    'type' => $response->question->type,
                    'answers' => [],
                    'response' => [
                        'student_answer' => $response->student_answer,
                        'answer_id' => $response->answer_id,
                        'submitted_at' => $response->submitted_at,
                    ],
                ];

                // Add answers
                foreach ($response->question->answers as $answer) {
                    $quizData[$quizId]['questions'][$questionId]['answers'][] = [
                        'id' => $answer->id,
                        'answer_text' => $answer->answer_text,
                        'is_correct' => $answer->is_correct,
                    ];
                }

                // Determine correctness and correct answer
                $correctAnswers = array_filter($quizData[$quizId]['questions'][$questionId]['answers'], fn($a) => $a['is_correct']);
                $correctAnswerText = $correctAnswers ? reset($correctAnswers)['answer_text'] : 'N/A';

                $isCorrect = false;
                if ($response->question->type === 'mcq') {
                    $selectedAnswer = array_filter($quizData[$quizId]['questions'][$questionId]['answers'], fn($a) => $a['id'] == $response->answer_id);
                    $isCorrect = $selectedAnswer && reset($selectedAnswer)['is_correct'];
                } elseif (in_array($response->question->type, ['truefalse', 'text'])) {
                    $isCorrect = $response->student_answer === $correctAnswerText;
                }

                $quizData[$quizId]['questions'][$questionId]['response']['is_correct'] = $isCorrect;
                $quizData[$quizId]['questions'][$questionId]['response']['correct_answer'] = $correctAnswerText;
            }
        }

        // Render the view with structured data
        return $this->render('attempted-quiz', [
            'quizData' => $quizData,
        ]);
    }

    public function actionDashboard($message = null)
    {
        //for student
        $this->layout = "student_layout";
        if (Helper::checkUserLoginAndValidate()) {
            return $this->redirect(['site/login']);
        }

        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->identity->usertype == 'admin') {
                $this->redirect(['site/adminpanel']);
            }
        }
        $user = $this->findModel(yii::$app->user->id);
        if (!$user) {
            if (true) {
                throw new ForbiddenHttpException('You are not allowed to access this page.');
            }
        }
        //  var_dump($message); exit;
        //  Yii::$app->session->setFlash('danger', $message);
        if ($message) {
            Yii::$app->session->setFlash('danger', $message);
        }
        $this->assignDemoSessions();

        $newsItems = News::find()
            ->select(['title', 'description']) // Include description in the select
            ->orderBy(['created_at' => SORT_DESC]) // Order by creation date descending
            ->limit(10) // Limit to 10 items
            ->all();

        $days = 15;
        $currentDate = date('Y-m-d H:i:s'); // Get the current time
        $fifteenDaysAgo = date('Y-m-d H:i:s', strtotime("-$days days", strtotime($currentDate))); // March 5, 2025

        $studentId = Yii::$app->user->identity->id;

        $assigned = StudentSessionAssignment::find()
            ->where(['student_id' => $studentId])
            ->andWhere(['>=', 'assigned_at', $fifteenDaysAgo])
            ->andWhere(['<=', 'assigned_at', $currentDate])
            ->with('session') // Eager load session details
            ->orderBy(['assigned_at' => SORT_DESC]) // Optional: sort by latest first
            ->all();

        // Fetch all session assignments with related quizzes and videos
        $assignments = StudentSessionAssignment::find()
            ->where(['student_id' => $studentId])
            ->with([
                'session' => function ($query) {
                    $query->with('quizlist.videos'); // Eager load quizzes and videos
                }
            ])
            ->all();

        // Count total videos
        $videoCount = 0;
        foreach ($assignments as $assignment) {
            // Check if session exists and has quizlist
            if ($assignment->session && !empty($assignment->session->quizlist)) {
                foreach ($assignment->session->quizlist as $quiz) {
                    $videoCount += count($quiz->videos); // Add the number of videos for each quiz
                }
            }
        }

        $sessionCount = count($user->sessions);
        $lectureCount = $videoCount;

        return $this->render('studentdashboard', [
            'model' => $user,
            'newsItems' => $newsItems,
            'assigned' => $assigned,
            'days' => $days,
            'sessionCount' => $sessionCount,
            'lectureCount' => $lectureCount,
        ]);
    }

    public function actionSessions($message = null)
    {
        //for student
        $this->layout = "student_layout";
        if (Helper::checkUserLoginAndValidate()) {
            return $this->redirect(['site/login']);
        }

        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->identity->usertype == 'admin') {
                $this->redirect(['site/adminpanel']);
            }
        }

        $studentId = Yii::$app->user->identity->id;
        $user = User::find()->with(['sessions'])->where(['id' => $studentId])->one();
        $sessions = Session::find()->all();

        if (!$user) {
            if (true) {
                throw new ForbiddenHttpException('You are not allowed to access this page.');
            }
        }

        return $this->render('student-sessions', [
            'sessions' => $sessions,
            'assignedSessions' => $user->sessions,
        ]);
    }

    public function actionLectures($message = null)
    {
        //for student
        $this->layout = "student_layout";
        if (Helper::checkUserLoginAndValidate()) {
            return $this->redirect(['site/login']);
        }

        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->identity->usertype == 'admin') {
                $this->redirect(['site/adminpanel']);
            }
        }

        $studentId = Yii::$app->user->identity->id;
        $user = User::find()->with(['sessions'])->where(['id' => $studentId])->one();

        if (!$user) {
            if (true) {
                throw new ForbiddenHttpException('You are not allowed to access this page.');
            }
        }
        // Fetch all session assignments with related quizzes and videos
        // $assignments = StudentSessionAssignment::find()
        //     ->where(['student_id' => $studentId])
        //     ->with([
        //         'session' => function ($query) {
        //             $query->with('quizlist.videos'); // Eager load quizzes and videos
        //         }
        //     ])
        //     ->all();
        $videos = Video::find()->with(['quiz.session'])->all();
        return $this->render('lectures', [
            'videos' => $videos,
        ]);
    }

    public function actionSubscribedlectures($id)
    {
        $this->layout = "student_layout";
        if (Helper::checkUserLoginAndValidate()) {
            return $this->redirect(['site/login']);
        }

        $quiz = Quiz::find()->with(['session'])->where(['id' => $id])->one();
        $session = $quiz->session;

        if (Yii::$app->user->identity->usertype == 'student' && Yii::$app->user->identity->fee_paid == 'no' && $session->type === "not_demo") {
            $m = 'cannot continue, your fee status is not marked "paid", 
        if you paid fee please contact our admin at <span style="font-weight:600;">admin@drcoachingacademy.com</span> or <span style="font-weight:600;">03365359967</span> to resolve issue';
            $this->redirect(['site/dashboard', 'message' => $m]);
        }

        $videos = Video::find()->where(['quiz_id' => $id])->all();
        $c = StudentSessionAssignment::find()->where(['student_id' => Yii::$app->user->id, 'session_id' => $session->id])->count();

        if ($c == 0) {
            if (true) {
                $m = 'Session is not assigned, Ask admin to assign.';
                $this->redirect(['site/dashboard', 'message' => $m]);
            }
        }

        return $this->render('subscribedlectures', [
            'videos' => $videos,
        ]);
    }

    public function actionQuizlist($id)
    {
        $this->layout = "student_layout";
        if (Helper::checkUserLoginAndValidate()) {
            return $this->redirect(['site/login']);
        }

        $session = Session::findOne($id);

        if (Yii::$app->user->identity->usertype == 'student' && Yii::$app->user->identity->fee_paid == 'no' && $session->type === "not_demo") {
            $m = 'cannot continue, your fee status is not marked "paid", if you paid fee please contact our admin at <span style="font-weight:600;">admin@drcoachingacademy.com</span> or <span style="font-weight:600;">03365359967</span> to resolve issue';
            // return $this->redirect(['site/dashboard', 'message' => $m]);

            Yii::$app->session->setFlash('danger', $m);
            return $this->redirect(Yii::$app->request->referrer);
        }

        $c = StudentSessionAssignment::find()->where(['student_id' => Yii::$app->user->id, 'session_id' => $id])->count();
        if ($c == 0) {
            if (true) {
                $m = 'Session is not assigned, Ask admin to assign.';
                // $this->redirect(['site/dashboard', 'message' => $m]);
                Yii::$app->session->setFlash('danger', $m);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        $quizlist = Quiz::find()->where(['session_id' => $id])->all();

        // Prepare an array to hold the quiz data with counts
        $quizData = [];
        foreach ($quizlist as $quiz) {
            // Get the count of questions for this quiz
            $questionCount = Question::find()->where(['quiz_id' => $quiz->id])->count();

            // Get the count of responses for the logged-in user
            $responseCount = StudentResponse::find()->where([
                'quiz_id' => $quiz->id,
                'student_id' => Yii::$app->user->id,
            ])->count();

            // Determine if attempted or not
            $attempted = ($questionCount == $responseCount) ? 1 : 0;
            // if($quiz->id == 7){
            //     echo"<pre>"; var_dump($questionCount.' = '.$responseCount); exit;
            // }

            // Add to quiz data
            $quizData[] = [
                'quiz' => $quiz,
                'questionCount' => $questionCount,
                'responseCount' => $responseCount,
                'attempted' => $attempted,
            ];
        }

        return $this->render('studentquizlist', [
            'quizData' => $quizData,
        ]);
    }

    public function actionQuizez()
    {
        // Set the layout for students
        $this->layout = 'student_layout';

        // Check if the user is logged in; redirect to login if not
        if (Helper::checkUserLoginAndValidate()) {
            return $this->redirect(['site/login']);
        }

        // Redirect admin users to the admin panel
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->usertype === 'admin') {
            return $this->redirect(['site/adminpanel']);
        }

        $studentId = Yii::$app->user->identity->id;

        // Fetch the user with their sessions and related quizzes
        $user = User::find()->with(['sessions.quizlist'])->where(['id' => $studentId])->one();

        if (!$user) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }

        $sessions = Session::find()->all();

        // Extract all quizzes from the user's sessions
        $quizData = [];
        foreach ($sessions as $session) {
            foreach ($session->quizlist as $quiz) {
                $questionCount = Question::find()->where(['quiz_id' => $quiz->id])->count();

                // Get the count of responses for the logged-in user
                $responseCount = StudentResponse::find()->where([
                    'quiz_id' => $quiz->id,
                    'student_id' => Yii::$app->user->id,
                ])->count();

                // Determine if attempted or not
                $attempted = ($questionCount == $responseCount) ? 1 : 0;
                $quizData[] = [
                    'quiz' => $quiz,
                    'session_name' => $session->name,
                    'attempted' => $attempted,
                ];
            }
        }

        // Set up pagination with 15 quizzes per page
        $dataProvider = new ArrayDataProvider([
            'allModels' => $quizData,
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'attributes' => [
                    'quiz.title',
                    'session_name',
                ],
            ],
        ]);

        return $this->render('quizez', [
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionProfile($id = null)
    {
        $this->layout = "student_layout";
        $loggedInUser = Yii::$app->user->identity;

        if (Helper::checkUserLoginAndValidate()) {
            return $this->redirect(['site/login']);
        }


        if ($loggedInUser->usertype === 'student') {
            $model = $this->findModel($loggedInUser->id);
            $getImages = UserImages::find()->where(['user_id' => $loggedInUser->id])->all();
        } elseif ($loggedInUser->usertype === 'admin') {
            if ($id === null) {
                $model = $this->findModel($loggedInUser->id);
                $getImages = UserImages::find()->where(['user_id' => $loggedInUser->id])->all();
            } else {
                $model = $this->findModel($id);
                $getImages = UserImages::find()->where(['user_id' => $id])->all();
            }
        } else {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }

        $sessions = Session::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->full_name = Yii::$app->request->post('User')['full_name'];
            // var_dump(Yii::$app->request->post('User')['full_name']);
            // exit();
            $model->number = Yii::$app->request->post('User')['number'];
            $model->city = Yii::$app->request->post('User')['city'];
            $model->father_name = Yii::$app->request->post('User')['father_name'];
            $model->gender = Yii::$app->request->post('User')['gender'];
            $model->cnic = Yii::$app->request->post('User')['cnic'];
            $model->uni = Yii::$app->request->post('User')['uni'];
            $model->workplace = Yii::$app->request->post('User')['workplace'];

            // Check if register_for exists in the POST data
            $selectedSessions = isset(Yii::$app->request->post('SignupForm')['register_for']) ?
                Yii::$app->request->post('SignupForm')['register_for'] : null;

            // Validate sessions
            if (is_array($selectedSessions) && !empty($selectedSessions)) {
                $model->register_for = implode(',', $selectedSessions);

                // Handle password change
                $newPassword = Yii::$app->request->post('User')['new_password'];
                if (!empty($newPassword)) {
                    $model->setPassword($newPassword);  // Set password hash
                }

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Profile updated successfully.');
                    return $this->redirect(['profile']);
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to update profile.');
                }
            } else {
                Yii::$app->session->setFlash('danger', 'Please select at least one session.');
            }
        }
        //  var_dump($getImages);
        //         exit();
        return $this->render('profile', [
            'model' => $model,
            'sessions' => $sessions,
            'getImages' => $getImages,
        ]);
    }

    public function actionCreateStream()
    {
        if (Helper::checkUserLoginAndValidate()) {
            return $this->redirect(['site/login']);
        }

        $model = Stream::find()->one();
        if ($model) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Stream updated successfully.');
                return $this->redirect(['create-stream']);
            }
        } else {
            $model = new Stream();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Stream created successfully.');
                return $this->redirect(['create-stream']);
            }
        }

        return $this->render('create-stream', [
            'model' => $model,
        ]);
    }

    // LIVE STREAM
    public function actionLiveStream()
    {
        $this->layout = "student_layout";
        $loggedInUser = Yii::$app->user->identity;

        if (Helper::checkUserLoginAndValidate()) {
            return $this->redirect(['site/login']);
        }
        // if (Yii::$app->user->identity->usertype == 'student' && Yii::$app->user->identity->fee_paid == 'no') {
        //     $m = 'cannot continue, your fee status is not marked "paid", if you paid fee please contact our admin at <span style="font-weight:600;">admin@drcoachingacademy.com</span> or <span style="font-weight:600;">03365359967</span> to resolve issue';
        //     $this->redirect(['site/dashboard', 'message' => $m]);
        // }

        $stream = Stream::find()->one();

        return $this->render('live-stream', [
            'stream' => $stream,
        ]);
    }


    public function actionUpload()
    {

        if (Helper::checkUserLoginAndValidate()) {
            return $this->redirect(['site/login']);
        }


        $userId = Yii::$app->user->id;
        $uploadedFiles = UploadedFile::getInstancesByName('images');

        $uploadsDir = 'uploads';

        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0755, true);
        }

        $imagePaths = [];

        foreach ($uploadedFiles as $file) {

            $filePath = $uploadsDir . '/' . uniqid() . '.' . $file->extension;

            if ($file->saveAs($filePath)) {
                $imagePaths[] = $filePath;

                $model = new UserImages();
                $model->user_id = $userId;
                $model->file_path = $filePath;

                if (!$model->save()) {
                    Yii::error('Failed to save image to database: ' . json_encode($model->errors));
                }
            } else {
                Yii::error('Failed to save file: ' . $file->name);
            }
        }

        $allImages = UserImages::find()
            ->select('file_path')
            ->where(['user_id' => $userId])
            ->asArray()
            ->all();

        $imagePaths = array_column($allImages, 'file_path');

        return $this->asJson($imagePaths);
    }

    public function actionDeleteImage()
    {

        if (Helper::checkUserLoginAndValidate()) {
            return $this->redirect(['site/login']);
        }


        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $filePath = Yii::$app->request->post('path');
        $userId = Yii::$app->user->id;

        $image = UserImages::findOne(['file_path' => $filePath, 'user_id' => $userId]);

        if ($image !== null) {
            if (file_exists($filePath) && unlink($filePath)) {

                $image->delete();

                return ['success' => true];
            } else {
                return ['success' => false, 'error' => 'File not found or unable to delete.'];
            }
        }

        return ['success' => false, 'error' => 'Image not found in the database.'];
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $sessions = Session::find()->orderBy(['ID' => SORT_DESC])->limit(4)->all();


        return $this->render('index', [
            'sessions' => $sessions,
        ]);
    }

    public function actionOnlinequizzes()
    {
        $quizes = Quiz::find()->with(['session'])->orderBy(['ID' => SORT_DESC])->limit(50)->all();


        return $this->render('online_quizzes', [
            'quizes' => $quizes,
        ]);
    }

    public function actionOnlinelectures($type = null)
    {
        if (!$type) {
            $type = '';
        }
        $sessions = Video::find()
            ->where(['is not', 'session_id', null])
            ->andWhere(['like', 'title', $type . ' '])
            ->orderBy(['ID' => SORT_DESC])
            ->limit(50)
            ->all();

        return $this->render('online_lectures', [
            'sessions' => $sessions,
        ]);
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {

        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->identity->usertype == 'admin') {
                $this->redirect(['site/adminpanel']);
            }
            if (Yii::$app->user->identity->usertype == 'student') {
                $this->redirect(['site/dashboard']);
            }
        }

        $model = new LoginForm();
        $postData = Yii::$app->request->post();
        if ($model->load($postData)) {

            $loginForm = $postData['LoginForm'];
            $isAlreadyLogin = User::find()
                ->where(['email' => $loginForm['username']])
                ->andWhere(['is not', 'timeout', null])
                ->one(); // or all(), depending on whether you want one user or multiple

            if ($isAlreadyLogin) {
                Yii::$app->db->createCommand()
                    ->delete('session', ['id' => $isAlreadyLogin->session_id])
                    ->execute();
                $isAlreadyLogin->last_user_agent = null;
                $isAlreadyLogin->ip = null;
                $isAlreadyLogin->session_id = null;
                $isAlreadyLogin->save();
            }

            if ($model->login()) {
                $user = User::findOne(Yii::$app->user->identity->id);
                $user->timeout = Helper::expireTime(86400); // 86400 seconds = 24 hours
                $user->last_user_agent = Yii::$app->request->userAgent;
                $user->ip = Yii::$app->request->userIP;
                $user->session_id = Yii::$app->session->getId();
                $user->login_time = Helper::expireTime(0);
                $user->save();
                if (Yii::$app->user->identity->usertype == 'admin') {
                    $this->redirect(['site/adminpanel']);
                }
                if (Yii::$app->user->identity->usertype == 'student') {
                    $this->redirect(['site/dashboard']);
                }
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionForgetPassword()
    {
        $model = new \yii\base\DynamicModel(['email']);
        $model->addRule(['email'], 'required')
            ->addRule(['email'], 'email');

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate()) {
            // Find the user by email
            $user = User::findOne(['email' => $model->email]);

            if ($user) {
                // Generate a new random password
                $newPassword = Yii::$app->security->generateRandomString(8);
                $user->setPassword($newPassword);

                // Save the new password
                if ($user->save()) {

                    Mail::SendResetEmail($user, $newPassword);

                    // Set success flash message
                    Yii::$app->session->setFlash('success', 'A new password has been sent to your email.');

                    return $this->redirect(['site/login']);
                }
            } else {
                // Set error flash message if the user is not found
                Yii::$app->session->setFlash('error', 'No user found with this email address.');
            }
        }

        // Render the form
        return $this->render('forget-password', [
            'model' => $model,
        ]);
    }

    public function actionAdminpanel()
    {

        if (Helper::checkUserLoginAndValidate()) {
            return $this->redirect(['site/login']);
        }

        //admin panel
        $data['student_paid'] = User::find()->where(['usertype' => 'student', 'status' => 'active', 'fee_paid' => 'yes'])->orderBy(['id' => SORT_DESC]) // Sorting by 'id' in descending order
            ->limit(100)->asArray()->all();

        $data['student_unpaid'] = User::find()->where(['usertype' => 'student', 'status' => 'active', 'fee_paid' => 'no'])->orderBy(['id' => SORT_DESC]) // Sorting by 'id' in descending order
            ->limit(100)->asArray()->all();

        $data['student_inactive'] = User::find()->where(['usertype' => 'student', 'status' => 'inactive'])->orderBy(['id' => SORT_DESC]) // Sorting by 'id' in descending order
            ->limit(100)->asArray()->all();

        $data['sessions'] = Session::find()->where(['status' => 'active'])->orderBy(['id' => SORT_DESC]) // Sorting by 'id' in descending order
            ->limit(100)->asArray()->all();

        $users = User::find()->orderBy(['id' => SORT_DESC])->all();

        // $data['student_paid']
        return $this->render('adminpanel', [
            'data' => $data,
        ]);
    }

    public function actionLogout()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        $user = User::findOne(Yii::$app->user->identity->id);
        if ($user) {
            Yii::$app->session->destroy($user->session_id); // Destroy session by ID
            Yii::$app->db->createCommand()
                ->delete('session', ['id' => $user->session_id])
                ->execute();
            $user->last_user_agent = null;
            $user->ip = null;
            $user->session_id = null;
            $user->save();
        }
        Yii::$app->user->logout();
        return $this->redirect(['site/login']);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionFaculty()
    {
        return $this->render('faculty');
    }
    public function actionCourses()
    {
        return $this->render('courses');
    }
    public function actionBlog()
    {
        return $this->render('blog');
    }
    public function actionEvent()
    {
        return $this->render('event');
    }
    public function actionAddmission()
    {
        return $this->render('addmission');
    }
    public function actionEvent_details()
    {
        return $this->render('event_details');
    }

    public function actionReattemptsRequests()
    {
        if (Helper::checkUserLoginAndValidate()) {
            return $this->redirect(['site/login']);
        }

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => Reattempts::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20, // Number of items per page
            ],
        ]);

        return $this->render('requests', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRequestReattempt()
    {
        // return $this->asJson(['data' => Yii::$app->request->post()]);
        if (Yii::$app->request->isPost) {

            $postData = Yii::$app->request->post('Reattempts');
            $studentId = Yii::$app->user->identity->id;
            $quizId = $postData['quiz_id'];
            $requested = Reattempts::find()->where(['student_id' => $studentId, 'quiz_id' => $quizId, 'status' => 0])->one();
            if ($requested) {
                Yii::$app->session->setFlash('error', 'You have already requested a reattempt for this quiz.');
                return $this->redirect(Yii::$app->request->referrer);
            }

            $model = new Reattempts();
            $model->student_id = $studentId;
            $model->status = 0; // Pending status
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Request submitted successfully.');
                // return $this->asJson(['success' => true, 'message' => 'Request submitted successfully']);
            }
            return $this->redirect(Yii::$app->request->referrer);
            // return $this->asJson(['success' => false, 'message' => implode(', ', $model->getFirstErrors())]);
        }
        throw new \yii\web\BadRequestHttpException('Invalid request method.');
    }
    public function actionApproveRequest($id)
    {
        $request = Reattempts::findOne($id);
        if ($request) {
            $request->status = 1;
            $request->updated_at = date('Y-m-d H:i:s');
            if ($request->save()) {

                $quizId = $request->quiz_id;
                $studentId = $request->student_id;

                // Ensure both `qid` and `sid` are provided
                if ($quizId && $studentId) {
                    // Delete the student response
                    StudentResponse::deleteAll(['quiz_id' => $quizId, 'student_id' => $studentId]);
                    QuizTimeLog::deleteAll(['quiz_id' => $quizId, 'student_id' => $studentId]);
                } else {
                    // Set an error flash message if parameters are missing
                    Yii::$app->session->setFlash('error', 'Invalid request parameters.');
                }
                Yii::$app->session->setFlash('success', 'Request approved successfully.');
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            Yii::$app->session->setFlash('error', 'Request not found.');
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionTerms()
    {
        return $this->render('terms');
    }

    public function actionMyLectures()
    {

        //for student
        $this->layout = "student_layout";
        if (Helper::checkUserLoginAndValidate()) {
            return $this->redirect(['site/login']);
        }

        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->identity->usertype == 'admin') {
                $this->redirect(['site/adminpanel']);
            }
        }

        $studentId = Yii::$app->user->identity->id;
        $user = User::find()->with(['sessions'])->where(['id' => $studentId])->one();

        if (!$user) {
            if (true) {
                throw new ForbiddenHttpException('You are not allowed to access this page.');
            }
        }

        $videos = Video::find()->with(['quiz.session'])->all();
        return $this->render('mylectures', [
            'videos' => $videos,
        ]);
    }
}
