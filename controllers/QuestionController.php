<?php


namespace app\controllers;

use app\components\Helper;
use app\components\ManualCache;
use Yii;
use app\models\Question;
use app\models\Answer;
use app\models\StudentResponse;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use app\models\Quiz;

class QuestionController extends Controller
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

    // Action for displaying the form and questions list
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }

        $model = new Question();
        $questions = Question::find()->with('answers')->all();

        return $this->render('index', [
            'model' => $model,
            'questions' => $questions,
        ]);
    }

    public function actionSubmitanswer()
    {
        //echo"<pre>"; var_dump($_REQUEST); exit;
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        if (!$this->request->isAjax || !$this->request->isPost) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        $studentId = Yii::$app->user->id;  // Get the logged-in user's ID

        $studentResponse = StudentResponse::find()
            ->where(['id' => $_REQUEST['id'], 'student_id' => $studentId])
            ->one();

        // Check if no result is found
        if (!$studentResponse) {
            throw new \yii\web\ForbiddenHttpException('You are not allowed to access this page.');
        }
        if ($_REQUEST['aid'] == '' ||  $_REQUEST['aid'] == null || !isset($_REQUEST['aid'])) {
            // exit('aliali');
            return $_REQUEST['id'];
        } else {

            $studentResponse->answer_id = $_REQUEST['aid'];
            $studentResponse->student_answer = $_REQUEST['at'] ?? null;
            if ($studentResponse->save(false)) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    public function actionGet()
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        $question = Question::find()->where(['quiz_id' => Yii::$app->request->get('quiz-id'), 'qnumber' => Yii::$app->request->get('qnumber')])->one();
        $answers = $question->getAnswers()->asArray()->all();

        $isAttempted = StudentResponse::find()->where(['question_id' => $question->id, 'student_id' => Yii::$app->user->identity->id])->one();

        $answerResult = 0;
        if ($isAttempted) {
            $isAnswer = Answer::find()->where(['id' => $isAttempted->answer_id])->one();
            if ($isAnswer->is_correct == true) {
                $answerResult = "Correct";
            }
        }
        $response = [
            'question' => $question->toArray(),
            'answers' => $answers,
            'attempted' => $isAttempted,
            'result' => $answerResult
        ];

        $data['success'] = true;
        $data['data'] = $response;

        return $this->asJson($data);
    }
    public function actionAllQuestions()
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        $questions = Question::find()
            ->with('answers')
            ->where(['quiz_id' => Yii::$app->request->get('quiz-id')])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();
        $data['questions'] = $questions;

        $cacheData = ManualCache::getCacheData();
        $matches = array_filter($cacheData, function ($item) {
            return $item['student_id'] == Yii::$app->user->identity->id && $item['quiz_id'] == Yii::$app->request->get('quiz-id');
        });

        $studentResponse = StudentResponse::find()
            ->where(['student_id' => Yii::$app->user->identity->id, 'quiz_id' => Yii::$app->request->get('quiz-id')])->all();

        $attempted = array_merge($studentResponse, $matches);

        $data['attempted'] = $attempted;

        return $this->asJson($data);
    }

    public function actionQSubmitAnswer()
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        getresponseagain:
        if ($this->request->isAjax) {

            $quizId = intval($_REQUEST['id']);
            $qnum = $_REQUEST['qnumber'];
            $answer = $_REQUEST['answer'];
            $sessionId = $_REQUEST['session'];

            $question = Question::find()->with('answers')->where(['quiz_id' => $quizId, 'qnumber' => $qnum])->one();
            $answer = Answer::find()->where(['id' => $answer])->one();
            if ($answer) {
                $answerid = $answer->id;
            }

            $studentResponse = new StudentResponse();
            $studentResponse->question_id = $question->id;
            $studentResponse->quiz_id = $quizId;
            $studentResponse->student_answer = $answer->answer_text;
            $studentResponse->student_id = Yii::$app->user->identity->id;
            $studentResponse->session_id = intval($sessionId);
            $studentResponse->answer_id = $answerid;
            $studentResponse->submitted_at = date('Y-m-d H:i:s');

            $cacheData = ManualCache::getCacheData();
            $newAns = [
                'question_id' => $studentResponse->question_id,
                'quiz_id' => $studentResponse->quiz_id,
                'student_answer' => $studentResponse->student_answer,
                'student_id' => $studentResponse->student_id,
                'session_id' => $studentResponse->session_id,
                'answer_id' => $studentResponse->answer_id,
                'submitted_at' => $studentResponse->submitted_at
            ];
            $cacheData[] = $newAns;
            ManualCache::saveCacheData($cacheData);

            // $studentResponse->save();

            $studentId = Yii::$app->user->identity->id; // Get the logged-in user's ID
            $cacheData = array_filter($cacheData, function ($submission) use ($studentId) {
                return $submission['student_id'] == $studentId;
            });
            if (count($cacheData) >= 10) {
                ManualCache::processStudentCache($studentId);
            }

            $data = [
                'success' => true,
                'attempted' => $newAns,
            ];

            return $this->asJson($data);
        }
    }

    public function actionAttempt()
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        getresponseagain:
        if ($this->request->isAjax) {
            if (isset($_REQUEST['rid_']) && $_REQUEST['rid_'] != null) {
                if (!isset($_SESSION['rid_'])) {
                    $_SESSION['rid_'] = []; // Initialize the array if not set
                }
                if (!in_array($_REQUEST['rid_'], $_SESSION['rid_'])) {
                    $_SESSION['rid_'][] = $_REQUEST['rid_'];
                }


                $ridArray = $_SESSION['rid_'];

                // Modify the query to check if 'id' is NOT in the session array
                $student_response = StudentResponse::find()
                    ->where([
                        'quiz_id' => $_REQUEST['id'],
                        'answer_id' => null,
                        'student_id' => Yii::$app->user->id
                    ])
                    ->andWhere(['not in', 'id', $ridArray]) // Exclude ids in the session array
                    ->orderBy(['created_at' => SORT_DESC])
                    ->one();
            } else {
                $student_response = StudentResponse::find()
                    ->where([
                        'quiz_id' => $_REQUEST['id'],
                        'answer_id' => null,
                        'student_id' => Yii::$app->user->id
                    ])
                    ->orderBy(['created_at' => SORT_DESC])
                    ->one();
            }


            if ($student_response) {
                $student_response->submitted_at = date('Y-m-d H:i:s');
                $student_response->save(false);
                $question = $this->findModel($student_response->question_id);
                $answers = $question->getAnswers()->asArray()->all();

                $response = [
                    'question' => $question->toArray(),
                    'answers' => $answers,
                    'rid' => $student_response->id
                ];
                $data['success'] = true;
                $data['data'] = $response;
                return $this->asJson($data);
            } else {
                //check if all questions are submitted
                $sub = StudentResponse::find()
                    ->where(['quiz_id' => $_REQUEST['id'], 'student_id' => Yii::$app->user->id])
                    ->andWhere(['IS NOT', 'answer_id', null]) // Count those that have been submitted
                    ->count();
                $qt = Question::find()->where(['quiz_id' => $_REQUEST['id']])->count();
                //  var_dump($sub == $qt); exit;
                if ($sub == $qt) {

                    if (isset($_SESSION['rid_'])) {
                        unset($_SESSION['rid_']); // This will completely remove the 'rid_' session variable
                    }
                    $data['success'] = false;
                    $data['message'] = 'all questions attempted';
                    $data['attempted'] = true;
                    return $this->asJson($data);
                } else {
                    if (isset($_SESSION['rid_'])) {
                        unset($_SESSION['rid_']);
                        unset($_REQUEST['rid_']);
                        goto getresponseagain;
                    }
                }
                $quiz = Quiz::findOne($_REQUEST['quiz_id']);
                $currentTime = date('Y-m-d H:i:s'); // Get the current time
                if ($currentTime >= $quiz->start_at && $currentTime <= $quiz->end_at) {
                    // There are still unanswered questions and the time is still valid
                    $data['success'] = true;
                    $data['message'] = 'There are unanswered questions remaining, but time is up';
                    $data['attempted'] = false;
                    return $this->asJson($data);
                }
                return 'cant work this way question already attempted';
            }
        } else {
            return 'cant work this way....';
        }
    }

    public function actionGetQuizQuestions($quiz_id)
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        $questions = Question::find()->where(['quiz_id' => $quiz_id])->orderBy(['id' => SORT_DESC])->all();

        return $this->renderPartial('_question_list', [
            'questions' => $questions,
        ]);
    }

    // Action for saving a question via Pjax
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        $model = new Question();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            //   echo"<pre>"; var_dump(Yii::$app->request->post()); exit;
            $qn = Question::find()->where(['quiz_id' => $model->quiz_id])->count();
            $model->qnumber = $qn + 1;

            if ($model->save()) {

                $model->save(false);
                // If MCQ, save answers
                if ($model->type == 'mcq') {
                    for ($i = 0; $i < 4; $i++) {
                        $answer = new Answer();
                        $answer->question_id = $model->id;
                        $answer->answer_text = Yii::$app->request->post('answers')[$i];
                        $answer->is_correct = (Yii::$app->request->post('correct_answer') == $i) ? 1 : 0;

                        if (!$answer->save()) {

                            $model->delete(); // Delete question if answers cannot be saved
                            return ['status' => 'error', 'message' => 'Error in saving MCQ answers.'];
                        }
                    }
                } elseif ($model->type == 'truefalse') {
                    // For True/False, save a single answer
                    $answer = new Answer();
                    $answer->question_id = $model->id;
                    $answer->answer_text = Yii::$app->request->post('truefalse_answer');
                    $answer->is_correct = 1;
                    if (!$answer->save()) {
                        $model->delete();
                        return ['status' => 'error', 'message' => 'Error in saving True/False answer.'];
                    }
                } elseif ($model->type == 'text') {
                    // For text answer, save the correct answer
                    $answer = new Answer();
                    $answer->question_id = $model->id;
                    $answer->answer_text = Yii::$app->request->post('text_answer');
                    $answer->is_correct = 1;

                    if (!$answer->save()) {

                        $model->delete();
                        // echo"<pre>"; var_dump($answer->getErrors()); exit; 
                        return ['status' => 'error', 'message' => 'Error in saving text answer.'];
                    }
                }
                // Success
                return [
                    'status' => 'success',
                    'message' => 'Question added successfully!',
                    'id' => $model->id,
                    'question_text' => $model->question_text, // Include question text
                    'type' => $model->type, // Include question type
                    'answers' => $model->answers // Include answers if necessary
                ];
            } else {
                // Validation error
                return ['status' => 'error', 'message' => $model->getErrors()];
            }
        }
    }

    public function actionDelete()
    {
        $request = Yii::$app->request;


        $questionId = $request->get('id');
        $quizId = $request->get('quiz_id'); // Get the quiz ID for redirection

        // Find the question by ID
        $question = Question::findOne($questionId);
        if ($question) {
            // Delete related answers
            foreach ($question->answers as $answer) {
                $answer->delete();
            }

            // Delete the question
            if ($question->delete()) {

                // Reorder remaining questions based on created_at
                $questions = Question::find()
                    ->where(['quiz_id' => $quizId])
                    ->orderBy(['created_at' => SORT_ASC])
                    ->all();

                $number = 1;
                foreach ($questions as $q) {
                    $q->qnumber = $number++;
                    $q->save(false); // Skip validation for speed
                }

                Yii::$app->session->setFlash('success', 'Question deleted successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to delete the question.');
            }
        }

        //  var_dump
        // Redirect to the quiz update page with the quiz ID
        return $this->redirect(['quiz/update', 'id' => $quizId]);
    }


    // Action for listing all questions (Ajax response)
    public function actionList()
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        $questions = Question::find()->with('answers')->all();
        return $this->renderPartial('_question_list', [
            'questions' => $questions,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Question::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
