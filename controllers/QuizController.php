<?php

namespace app\controllers;

use app\components\Helper;
use app\components\ManualCache;
use DateTime;
use Yii;
use app\models\Quiz;
use app\models\StudentResponse;
use app\models\QuizSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Session;
use yii\helpers\ArrayHelper;
use app\models\Answer;
use app\models\Question;
use app\models\QuizTimeLog;
use app\models\StudentSessionAssignment;
use app\models\User;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;
use app\models\Video;
use yii\db\Exception as DbException;
use yii\helpers\Url;

/**
 * QuizController implements the CRUD actions for Quiz model.
 */
class QuizController extends Controller
{
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
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Quiz models.
     *
     * @return string
     */ public function actionIndex()
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }

        $searchModel = new QuizSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }

        $model = new Quiz();
        $sessions = ArrayHelper::map(Session::find()->all(), 'id', 'name');
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // $model->start_at = date('Y-m-d H:i:s', strtotime($model->start_at));
                // $model->end_at = date('Y-m-d H:i:s', strtotime($model->end_at));
                if ($model->save()) {
                    return $this->redirect(['update', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'sessions' => $sessions
        ]);
    }

    /**
     * Updates an existing Quiz model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }

        $model = $this->findModel($id);
        $question = new Question();
        $answer = new Answer();
        $saved_questions = Question::find()
            ->where(['quiz_id' => $id])
            ->with('answers') // Eager load related answers
            ->orderBy(['id' => SORT_DESC]) // Order by ID in descending order
            ->all();

        $sessions = ArrayHelper::map(Session::find()->all(), 'id', 'name');
        if ($this->request->isPost && $model->load($this->request->post())) {
            // $model->start_at = date('Y-m-d H:i:s', strtotime($model->start_at));
            // $model->end_at = date('Y-m-d H:i:s', strtotime($model->end_at));
            if ($model->save()) {
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        $video = Video::find()->where(['quiz_id' => $id])->all();
        $size = Helper::getFolderSize(Yii::getAlias('@app/uploads/videos'));
        $sizeInMB = round($size / (1024 * 1024), 2);
        $sizeInGB = round($sizeInMB / 1024, 2);

        return $this->render('update', [
            'model' => $model,
            'sessions' => $sessions,
            'question' => $question,
            'saved_questions' => $saved_questions,
            'answer' => $answer,
            'video' => $video,
            'quiz_id' => $id,
            'size' => $sizeInGB
        ]);
    }

    public function actionAttemptNow($id)
    {
        $quiz = Quiz::find()->with(['session'])->where(['id' => $id])->one();

        $session = $quiz->session;

        if (Yii::$app->user->identity->usertype == 'student' && Yii::$app->user->identity->fee_paid == 'no' && $session->type === "not_demo") {
            $m = 'cannot continue, your fee status is not marked "paid", if you paid fee please contact our admin at <span style="font-weight:600;">admin@drcoachingacademy.com</span> or <span style="font-weight:600;">03365359967</span> to resolve issue';
            // return $this->redirect(['site/dashboard', 'message' => $m]);

            Yii::$app->session->setFlash('danger', $m);
            return $this->redirect(Yii::$app->request->referrer);
        }

        $c = StudentSessionAssignment::find()->where(['student_id' => Yii::$app->user->id, 'session_id' => $session->id])->count();
        if ($c == 0) {
            if (true) {
                $m = 'Session is not assigned, Ask admin to assign.';
                // $this->redirect(['site/dashboard', 'message' => $m]);
                Yii::$app->session->setFlash('danger', $m);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        $currentTime = date('Y-m-d H:i:s'); // Get the current time
        $quizTime = QuizTimeLog::find()->where(['student_id' => Yii::$app->user->identity->id, 'quiz_id' => $id])->one();
        if (!$quizTime) {
            $quizTime = new QuizTimeLog();
            $quizTime->quiz_id = $id;
            $quizTime->student_id = Yii::$app->user->identity->id;
            $quizTime->total_time = $quiz->duration_in_minutes;
            $quizTime->spend_time = 0;
            $quizTime->start_time = $currentTime;
            $quizTime->log_time = $currentTime;
            $quizTime->save();
        }

        $startTime = $quizTime->start_time;
        $endTime = $quizTime->log_time;

        $currentTime = date('Y-m-d H:i:s');
        // Create DateTime objects
        $start = new DateTime($startTime);
        $end = new DateTime($currentTime);

        // Calculate the difference
        $interval = $start->diff($end);

        // Convert the difference to total minutes
        $duration = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
        if ($duration >= $quizTime->total_time) {
            Yii::$app->session->setFlash('danger', "Time is up to attempt this quiz.");
            // return $this->redirect(Yii::$app->request->referrer);
            return $this->redirect(['quiz/result?id=' . $quiz->id]);
        }

        $studentResponses = StudentResponse::find()->where(['student_id' => Yii::$app->user->identity->id, 'quiz_id' => $id])->all();
        if (count($studentResponses) == count($quiz->questions)) {
            // Add a flash message
            Yii::$app->session->setFlash('warning', 'you have attempted these quizes.');

            return $this->redirect(['quiz/result?id=' . $quiz->id]);
        }

        $cacheData = ManualCache::getCacheData();
        $matches = array_filter($cacheData, function ($item) {
            return $item['student_id'] == Yii::$app->user->identity->id && $item['quiz_id'] == Yii::$app->request->get('id');
        });

        if ($matches && (count($matches) >= count($quiz->questions))) {
            ManualCache::processStudentCache(Yii::$app->user->identity->id);
            // Add a flash message
            Yii::$app->session->setFlash('warning', 'you have attempted these quizes.');
            return $this->redirect(['quiz/result?id=' . $quiz->id]);
        }

        // Check if current time is outside the quiz start and end time
        if ($currentTime < $quiz->start_at) {
            Yii::$app->session->setFlash('danger', 'You can attempt in future.');
            return $this->redirect(Yii::$app->request->referrer);
        }
        if ($currentTime > $quiz->end_at) {
            Yii::$app->session->setFlash('danger', 'You cannot attempt this quiz, Time is up.');
            return $this->redirect(Yii::$app->request->referrer);
        }

        // echo"<pre>"; var_dump($data); exit;
        return $this->render('attempt-now', [
            'quiz' => $quiz,
            'quizTime' => $quizTime
        ]);
    }

    public function actionTimeLog()
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        getresponseagain:
        if ($this->request->isAjax) {

            $id = $_REQUEST['id'];
            $time = $_REQUEST['time'];

            $currentTime = date('Y-m-d H:i:s'); // Get the current time
            $quizTime = QuizTimeLog::find()->where(['student_id' => Yii::$app->user->identity->id, 'quiz_id' => $id])->one();
            if ($quizTime) {
                $quizTime->spend_time += intval($time);
                $currentTime = time();
                $quizTime->log_time = $currentTime;
                $quizTime->save();
            }
            $data = $quizTime;

            return $this->asJson($data);
        }
    }

    public function actionResult($id)
    {
        $this->layout = "student_layout";
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }

        $quiz = Quiz::find()->with(['questions'])->where(['id' => $id])->one();

        $data = [
            'totalQuestion' => count($quiz->questions),
            'totalCorrect' => 0,
            'totalIncorrect' => 0,
            'unAttempted' => 0,
        ];

        foreach ($quiz->questions as $key => $q) {
            $answer = Answer::find()->where(['question_id' => $q->id, 'is_correct' => 1])->one();
            $attempted = StudentResponse::find()->where(['question_id' => $q->id, 'student_id' => Yii::$app->user->id])->one();
            if ($attempted) {
                if ($attempted->answer_id == $answer->id) {
                    $data['totalCorrect'] = $data['totalCorrect'] + 1;
                } else {
                    $data['totalIncorrect'] = $data['totalIncorrect'] + 1;
                }
            } else {
                $data['unAttempted'] = $data['unAttempted'] + 1;
            }
        }

        // echo"<pre>"; var_dump($data); exit;
        return $this->render('student_result', [
            'data' => $data,
        ]);
    }

    // public function actionResult($id)
    // {
    //     $this->layout = "student_layout";
    //     if (Yii::$app->user->isGuest) {
    //         throw new ForbiddenHttpException('You are not allowed to access this page.');
    //     }

    //     $videos = Video::find()->where(['quiz_id' => $id])->all();
    //     $sr = StudentResponse::find()->where(['quiz_id' => $id, 'student_id' => Yii::$app->user->id])
    //         ->orderBy(['created_at' => SORT_DESC])->all();
    //     $data = [];
    //     $d = 1;
    //     if ($sr) {

    //         foreach ($sr as $s) {
    //             // exit('ali');
    //             $data_ = null;

    //             if (isset($s) && $s->answer_id != NULL) {
    //                 // exit('underdevelopment');
    //                 $ans = Answer::find()->where(['question_id' => $s->question_id, 'is_correct' => 1])->one();
    //                 //  $query = Answer::find()->where(['question_id' => $s->question_id, 'is_correct' => 1])->one();
    //                 // if(!$ans){
    //                 //     var_dump($s->question_id); exit;
    //                 // }

    //                 if (isset($ans) && $ans->id == $s->answer_id) {
    //                     $r = 'correct answer';
    //                     $data_ = ['qn' => $d, 'correct' => $r];
    //                 } else {
    //                     $r = 'wrong answer';
    //                     $data_ = ['qn' => $d, 'correct' => $r];
    //                 }
    //             } else {
    //                 $r = 'wrong answer';
    //                 $data_ = ['qn' => $d, 'correct' => $r];
    //             }
    //             if ($data_) {
    //                 $data[] = $data_;
    //             }
    //             $d++;
    //         }

    //         // echo"<pre>"; var_dump($data); exit;
    //         return $this->render('student_result', [
    //             'data' => $data,
    //             'videos' => $videos,
    //         ]);
    //     }
    // }

    public function actionDelete($id)
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Quiz model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Quiz the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Quiz::findOne(['id' => $id]);
        // echo"<pre>"; var_dump($id); exit;
        if (!$model)
            throw new NotFoundHttpException('The requested page does not exist, or data not found against request id');
        else
            return $model;
    }

    public function actionPlayvideo($id)
    {
        $this->layout = "student_layout";
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }

        $session = Session::findOne(Yii::$app->request->get('session-id'));
        if ($session) {
            if (Yii::$app->user->identity->usertype == 'student' && Yii::$app->user->identity->fee_paid == 'no' && $session->type === "not_demo") {
                $m = 'cannot continue, your fee status is not marked "paid", if you paid fee please contact our admin at <span style="font-weight:600;">admin@drcoachingacademy.com</span> or <span style="font-weight:600;">03365359967</span> to resolve issue';
                // return $this->redirect(['site/dashboard', 'message' => $m]);

                Yii::$app->session->setFlash('danger', $m);
                return $this->redirect(Yii::$app->request->referrer);
            }

            $c = StudentSessionAssignment::find()->where(['student_id' => Yii::$app->user->id, 'session_id' => $session->id])->count();
            if ($c == 0) {
                if (true) {
                    $m = 'Session is not assigned, Ask admin to assign.';
                    // $this->redirect(['site/dashboard', 'message' => $m]);
                    Yii::$app->session->setFlash('danger', $m);
                    return $this->redirect(Yii::$app->request->referrer);
                }
            }
        }

        $videoUrl = Yii::$app->urlManager->createUrl(['quiz/stream', 'id' => $id]);  // A separate action to stream the video

        // Render the view with the video URL
        return $this->render('play', [
            'videoUrl' => $videoUrl,
        ]);
    }

    public function actionPlay($id)
    {
        $this->layout = "student_layout";
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }

        $session = Session::findOne(Yii::$app->request->get('session-id'));
        if ($session) {
            if (Yii::$app->user->identity->usertype == 'student' && Yii::$app->user->identity->fee_paid == 'no' && $session->type === "not_demo") {
                $m = 'cannot continue, your fee status is not marked "paid", if you paid fee please contact our admin at <span style="font-weight:600;">admin@drcoachingacademy.com</span> or <span style="font-weight:600;">03365359967</span> to resolve issue';
                // return $this->redirect(['site/dashboard', 'message' => $m]);

                Yii::$app->session->setFlash('danger', $m);
                return $this->redirect(Yii::$app->request->referrer);
            }

            $c = StudentSessionAssignment::find()->where(['student_id' => Yii::$app->user->id, 'session_id' => $session->id])->count();
            if ($c == 0) {
                if (true) {
                    $m = 'Session is not assigned, Ask admin to assign.';
                    // $this->redirect(['site/dashboard', 'message' => $m]);
                    Yii::$app->session->setFlash('danger', $m);
                    return $this->redirect(Yii::$app->request->referrer);
                }
            }
        }
        $decodedId = Helper::decodeId($id);
        $file = Video::findOne($decodedId);
;
        $videoUrl = Url::to([$file->file_path]);  // A separate action to stream the video

        // Render the view with the video URL
        return $this->render('myplay', [
            'videoUrl' => $videoUrl,
        ]);
    }

    // public function actionStream($id)
    // {
    //     if (Yii::$app->user->isGuest) {
    //         throw new ForbiddenHttpException('You are not allowed to access this page.');
    //     }

    //     $decodedId = Helper::decodeId($id);
    //     // Now you have the decrypted ID, you can use it to find the video
    //     $file = Video::findOne($decodedId);

    //     if ($file) {
    //         $filePath = Yii::getAlias('@app/') . $file->file_path;

    //         return Yii::$app->response->sendFile($filePath, $file->file_path, [
    //             'mimeType' => 'video/mp4',
    //             'inline' => true,
    //         ]);
    //     }
    // }

    public function actionStream($id)
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }

        $decodedId = Helper::decodeId($id);
        $file = Video::findOne($decodedId);

        if (!$file) {
            throw new NotFoundHttpException('Video not found.');
        }

        $filePath = Yii::getAlias('@app/') . $file->file_path;

        if (!file_exists($filePath)) {
            throw new NotFoundHttpException('Video file not found.');
        }

        $size = filesize($filePath);
        $start = 0;
        $end = $size - 1;
        $length = $size;

        header('Content-Type: video/mp4');
        header('Accept-Ranges: bytes');

        if (isset($_SERVER['HTTP_RANGE'])) {
            preg_match('/bytes=(\d+)-(\d*)/', $_SERVER['HTTP_RANGE'], $matches);
            $start = intval($matches[1]);
            $end = isset($matches[2]) && $matches[2] !== '' ? intval($matches[2]) : $end;
            $length = $end - $start + 1;

            header('HTTP/1.1 206 Partial Content');
            header("Content-Range: bytes $start-$end/$size");
        } else {
            header('HTTP/1.1 200 OK');
        }

        header('Content-Length: ' . $length);

        $fp = fopen($filePath, 'rb');
        fseek($fp, $start);

        $bufferSize = 8192;
        $bytesSent = 0;

        while (!feof($fp) && $bytesSent < $length) {
            $chunkSize = min($bufferSize, $length - $bytesSent);
            echo fread($fp, $chunkSize);
            flush();
            $bytesSent += $chunkSize;
        }

        fclose($fp);
        exit;
    }


    public function actionDeletevideo($id, $is_session = null)
    {
        // Find the quiz by its ID
        $model = Video::findOne($id);

        if ($model) {
            // Delete the file from the server
            $filePath = Yii::getAlias('@webroot') . '/' . $model->file_path;  // Example file path

            if (file_exists($filePath)) {
                // Attempt to delete the file
                if (unlink($filePath)) {
                    // Delete the quiz
                    $model->delete();
                    // Set a success flash message
                    Yii::$app->session->setFlash('success', 'Video deleted successfully.');
                } else {
                    Yii::$app->session->setFlash('error', 'Error: File could not be deleted.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Error: File does not exist.');
            }
        } else {
            // Set an error flash message
            Yii::$app->session->setFlash('error', 'Video not found.');
        }
        if ($is_session) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        // Redirect to the index or wherever you want after deletion
        return $this->redirect(['quiz/index']); // Redirect to the quiz listing page
    }


    // public function actionAttempt($id)
    // {
    //     $model = $this->findModel($id);
    //     $currentTime = time();

    //     // Check if the quiz is currently available
    //     if ($currentTime >= strtotime($model->start_at) && $currentTime <= strtotime($model->end_at)) {
    //         // Get all questions related to the quiz
    //         $questions = \app\models\Question::find()
    //             ->where(['quiz_id' => $id])
    //             ->with('answers') // Assuming 'options' is a relation in the Question model
    //             ->all();

    //         // Retrieve existing student responses
    //         $studentResponses = \app\models\StudentResponse::find()
    //             ->where(['student_id' => 1]) // Replace '1' with the current student's ID
    //             ->andWhere(['in', 'question_id', array_column($questions, 'id')])
    //             ->all();

    //             // Loop through each question and create a student response if it doesn't exist yet
    //     foreach ($questions as $question) {
    //         if (!isset($studentResponses[$question->id])) {
    //             // Create a new student response for unanswered questions
    //             $newResponse = new \app\models\StudentResponse();
    //             $newResponse->student_id = 1;
    //             $newResponse->question_id = $question->id;
    //             $newResponse->save();

    //             // Add the newly created response to the array
    //             $studentResponses[$question->id] = $newResponse;
    //         }
    //     }

    //         // Convert the student responses to a key-value pair for easy access
    //         $studentResponses = \yii\helpers\ArrayHelper::index($studentResponses, 'question_id');

    //         return $this->render('attempt', [
    //             'model' => $model,
    //             'questions' => $questions,
    //             'studentResponses' => $studentResponses,
    //         ]);
    //     } else {
    //         Yii::$app->session->setFlash('error', 'Quiz is not available at this time.');
    //         return $this->redirect(['update', 'id' => $id]);
    //     }
    // }

    public function actionAttempt($id = null)
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        if (Yii::$app->user->identity->usertype == 'admin') {
            throw new ForbiddenHttpException('You are not allowed to attempt quiz as you are admin');
        }
        $id = $_REQUEST['id'];
        $model = $this->findModel($_REQUEST['id']);
        $session_id = $model->session_id;
        // var_dump('ali'); exit;

        $currentDateTime = date('Y-m-d H:i:s');
        // Convert the `start_at` and `end_at` to Unix timestamps
        $startDateTime = ($model->start_at);
        $endDateTime = ($model->end_at);
        // var_dump($currentDateTime);
        // var_dump($startDateTime); 
        // var_dump($endDateTime); exit;
        // Check if the current time is between start and end times
        if ($currentDateTime >= $startDateTime && $currentDateTime <= $endDateTime) {

            $studentId = Yii::$app->user->id;

            //record to check student response on this quiz already submitted or not
            $studentResponseCount = \app\models\StudentResponse::find()
                ->where(['student_id' => $studentId])
                ->andWhere(['quiz_id' => $id])
                ->count(); // This will return the number of rows

            //var_dump($studentResponseCount); exit;
            if ($studentResponseCount > 0) {
                //record found meaning already attempted
                // Add a flash message
                Yii::$app->session->setFlash('warning', 'you have already attempted this exam');

                // Redirect to the 'quizlist' action with the 'id' parameter
                return $this->redirect(['site/quizlist', 'id' => $session_id]);
            } else {
                $questions = Question::find()->where(['quiz_id' => $id])->asArray()->all();
                // echo"<pre>"; var_dump($questions); exit;
                if (!$questions) {
                    //record found meaning already attempted
                    // Add a flash message
                    Yii::$app->session->setFlash('warning', 'this quiz has no questions');

                    // Redirect to the 'quizlist' action with the 'id' parameter
                    return $this->redirect(['site/quizlist', 'id' => $session_id]);
                } else {
                    $rowsToInsert = [];
                    foreach ($questions as $question) {
                        $rowsToInsert[] = [
                            'student_id' => $studentId,
                            'question_id' => $question['id'], // Accessing id from array
                            'quiz_id' => $id,
                            'created_at' => date('Y-m-d H:i:s'), // Set created_at to current time
                            'session_id' => $session_id
                            // Set updated_at to current time
                        ];
                    }
                }

                // if(Yii::$app->user->id == 11){
                //     echo"<pre>"; var_dump($questions); exit;
                // }

                // Bulk insert into StudentResponse table
                if (!empty($rowsToInsert)) {
                    $command = Yii::$app->db->createCommand()->batchInsert('student_response', ['student_id', 'question_id', 'quiz_id', 'created_at', 'session_id'], $rowsToInsert);
                    $command->execute(); // Execute the command
                }

                $insertedCount = count($rowsToInsert);
                if ($insertedCount > 0) {
                    //send data for json format
                    // $studentResponse['data'] = StudentResponse::find()->where(['student_id' => $studentId, 'quiz_id' => $id])->asArray()->all();
                    $studentResponse['success'] = true;
                    // Set the response format to JSON
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                    // Return the student responses in JSON format
                    return $studentResponse;
                }
            }
        } else {
            // Quiz is not available

            Yii::$app->session->setFlash('error', 'Quiz is not available at this time.');
            return $this->redirect(['site/quizlist', 'id' => $session_id]);
        }
    }

    public function actionSubmitAttempt($id)
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        $model = $this->findModel($id);
        $currentTime = time();

        if ($currentTime >= strtotime($model->start_at) && $currentTime <= strtotime($model->end_at)) {
            $answers = Yii::$app->request->post('answers');

            foreach ($answers as $questionId => $answerId) {
                // Check if a response already exists
                $studentResponse = \app\models\StudentResponse::find()
                    ->where(['student_id' => 1]) // Replace '1' with the current student's ID
                    ->where('question_id', $questionId)
                    ->first();

                if ($studentResponse) {
                    // Update existing response
                    $studentResponse->answer_id = $answerId;
                    $studentResponse->save();
                    // exit('aliali');
                } else {

                    if (isset($_SESSION['rid_'])) {
                        unset($_SESSION['rid_']); // This will completely remove the 'rid_' session variable
                    }
                    // Create new response
                    $newResponse = new StudentResponse;
                    $newResponse->student_id = 1; // Replace with the actual student ID
                    $newResponse->question_id = $questionId;
                    $newResponse->answer_id = $answerId;
                    $newResponse->save();
                }
            }

            return $this->asJson(['status' => 'success']);
        } else {
            return $this->asJson(['status' => 'error', 'message' => 'Time is finished.']);
        }
    }

    // public function actionUploadvideo()
    // {
    //     if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
    //         throw new ForbiddenHttpException('You are not allowed to access this page.');
    //     }

    //     $size = Helper::getFolderSize(Yii::getAlias('@app/uploads/videos'));
    //     $sizeInMB = round($size / (1024 * 1024), 2);
    //     $sizeInGB = round($sizeInMB / 1024, 2);

    //     // Correct instantiation of the Video model
    //     $model = new \app\models\Video();

    //     $model->file_path = UploadedFile::getInstance($model, 'file_path');
    //     if ($model->file_path) {
    //         $filePath = 'uploads/videos/' . uniqid() . '.' . $model->file_path->extension;
    //         $model->file_path->saveAs($filePath);
    //         $model->file_path = $filePath;
    //         $model->quiz_id = $_REQUEST['Video']['quiz_id'];
    //         $model->title = $_REQUEST['Video']['title'];
    //         // echo"<pre>"; var_dump($model); exit;
    //         if ($model->save(false)) {
    //             Yii::$app->session->setFlash('success', 'Video uploaded successfully.');
    //             return $this->redirect(['quiz/update', 'id' => $model->quiz_id]);
    //         }
    //     }

    //     return $this->redirect(['quiz/update', 'id' => $model->quiz_id]);
    // }

    public function actionUploadvideo()
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }

        // Get current folder size
        $folderPath = Yii::getAlias('@app/uploads/videos');
        $currentSizeInBytes = Helper::getFolderSize($folderPath);
        $currentSizeInMB = round($currentSizeInBytes / (1024 * 1024), 2);
        $currentSizeInGB = round($currentSizeInMB / 1024, 2);

        // Instantiate the Video model
        $model = new Video();

        // Get the uploaded file
        $model->file_path = UploadedFile::getInstance($model, 'file_path');

        if ($model->file_path) {
            // Get the size of the uploaded file in bytes
            $uploadedFileSizeInBytes = $model->file_path->size;
            $uploadedFileSizeInGB = round($uploadedFileSizeInBytes / (1024 * 1024 * 1024), 2);

            // Calculate total size after upload (in GB)
            $totalSizeInGB = $currentSizeInGB + $uploadedFileSizeInGB;

            // Define the size limit (97 GB)
            $sizeLimitInGB = 97;

            // Check if total size exceeds 97 GB
            if ($totalSizeInGB > $sizeLimitInGB) {
                Yii::$app->session->setFlash('error', "Upload failed: Total size ({$totalSizeInGB} GB) exceeds the 97 GB limit.");
                // Redirect back to the referring URL or a default URL
                $referrer = Yii::$app->request->referrer ?: ['quiz/update', 'id' => $_REQUEST['Video']['quiz_id']];
                return $this->redirect($referrer);
            }

            // Proceed with file upload
            $filePath = 'uploads/videos/' . uniqid() . '.' . $model->file_path->extension;
            $model->file_path->saveAs($filePath);
            $model->file_path = $filePath;
            $model->quiz_id = $_REQUEST['Video']['quiz_id'];
            $model->title = $_REQUEST['Video']['title'];

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Video uploaded successfully.');
                return $this->redirect(['quiz/update', 'id' => $model->quiz_id]);
            }
        }

        // Redirect if no file uploaded or upload fails
        return $this->redirect(['quiz/update', 'id' => $model->quiz_id]);
    }


    public function actionResults($id)
    {
        // Validate quiz_id
        if (!is_numeric($id) || $id <= 0) {
            throw new NotFoundHttpException('Invalid quiz ID provided.');
        }

        // Check if the quiz exists
        $quiz = Quiz::findOne($id);
        if ($quiz === null) {
            throw new NotFoundHttpException('The requested quiz does not exist.');
        }

        try {
            // Fetch total number of questions for the quiz
            $totalQuestions = Question::find()
                ->where(['quiz_id' => $id])
                ->count();

            // If no questions exist, set a default or handle accordingly
            if ($totalQuestions === '0') {
                $totalQuestions = 0; // Explicitly set to 0 for clarity
            }

            // Query to fetch distinct student_ids for the quiz
            $query = StudentResponse::find()
                ->select('student_id')
                ->where(['quiz_id' => $id])
                ->distinct();

            // Create an ActiveDataProvider for pagination
            $dataProvider = new ActiveDataProvider([
                'query' => User::find()
                    ->where(['id' => $query])
                    ->andWhere(['usertype' => 'student']), // Ensure only students
                'pagination' => [
                    'pageSize' => 10, // Adjustable
                    'pageSizeLimit' => [1, 50], // Prevent excessive page sizes
                ],
                'sort' => [
                    'defaultOrder' => ['id' => SORT_ASC],
                    'attributes' => [
                        'id',
                        'full_name',
                        'email',
                    ],
                ],
            ]);

            // Fetch students for the current page
            $students = $dataProvider->getModels();

            // Calculate results for each student
            $results = [];
            foreach ($students as $student) {
                if ($student === null) {
                    continue; // Skip if student data is somehow missing
                }

                $correctCount = StudentResponse::find()
                    ->innerJoin('answer', 'student_response.answer_id = answer.id')
                    ->where([
                        'student_response.student_id' => $student->id,
                        'student_response.quiz_id' => $id,
                        'answer.is_correct' => 1,
                    ])
                    ->count();

                $incorrectCount = $totalQuestions - $correctCount;

                $results[$student->id] = [
                    'student' => $student,
                    'correct' => (int)$correctCount, // Ensure integer
                    'incorrect' => max(0, $incorrectCount), // Prevent negative values
                ];
            }

            // If no students have responded
            if (empty($results)) {
                $results = []; // Explicitly set to empty array
            }

            return $this->render('results', [
                'results' => $results,
                'quiz_id' => $id,
                'totalQuestions' => $totalQuestions,
                'dataProvider' => $dataProvider,
            ]);
        } catch (DbException $e) {
            // Handle database-related errors
            Yii::$app->session->setFlash('error', 'A database error occurred: ' . $e->getMessage());
            return $this->redirect(['index']);
        } catch (\Exception $e) {
            // Handle any other unexpected errors
            Yii::$app->session->setFlash('error', 'An unexpected error occurred: ' . $e->getMessage());
            return $this->redirect(['index']);
        }
    }
}
