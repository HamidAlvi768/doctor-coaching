<?php

namespace app\controllers;

use app\components\Helper;
use Yii;
use app\models\User;
use app\models\Quiz;
use app\models\QuizTimeLog;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\StudentSessionAssignment;
use app\models\Session;
use app\models\StudentResponse;
use app\models\UserImages;
use yii\web\Response;
use yii\web\ForbiddenHttpException;


class UserController extends Controller
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

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }

        // Get the current user model (if needed)
        $model = User::findOne(Yii::$app->user->id); // Get the currently logged-in user

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'allusers' => $dataProvider,
            'usermodel' => $searchModel,
            'model' => $model, // Pass the model to the view
        ]);
    }

    public function actionForceLogout($id)
    {

        $isAlreadyLogin = User::findOne($id); // or all(), depending on whether you want one user or multiple

        if ($isAlreadyLogin) {
            Yii::$app->db->createCommand()
                ->delete('session', ['id' => $isAlreadyLogin->session_id])
                ->execute();
            $isAlreadyLogin->last_user_agent = null;
            $isAlreadyLogin->ip = null;
            $isAlreadyLogin->session_id = null;
            $isAlreadyLogin->save();
        }
        $this->redirect(['user/index']);
    }

    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        $model = $this->findModel($id);

        // Get all available sessions
        $sessions = Session::find()->all();

        // Get assigned sessions
        $assignedSessions = $model->sessions;
        $getImages = UserImages::find()->where(['user_id' => $id])->all();
        $sr1 = QuizTimeLog::find()
            ->select('quiz_id')
            ->where(['student_id' => $id])
            ->distinct()
            ->column();
        $sr2 = StudentResponse::find()
            ->select('quiz_id')
            ->where(['student_id' => $id])
            ->distinct()
            ->column();

        // Merge both arrays
        $uniquIds = array_merge($sr1, $sr2);
        $quizIds = implode(',', $uniquIds);

        $quizIdsString = $quizIds; // Example string
        $quizIdsArray = explode(',', $quizIdsString); // Convert to array

        // Fetch the quizzes that match the IDs
        $attempted_quiz = Quiz::find()
            ->where(['id' => $quizIdsArray])
            ->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->full_name = Yii::$app->request->post('User')['full_name'];
            // var_dump(Yii::$app->request->post('User')['full_name']);
            // exit();
            $model->number = Yii::$app->request->post('User')['number'];
            $model->email = Yii::$app->request->post('User')['email'];
            $model->username = Yii::$app->request->post('User')['email'];
            $model->fee_paid = Yii::$app->request->post('User')['fee_paid'];
            $model->status = Yii::$app->request->post('User')['status'];
            $model->city = Yii::$app->request->post('User')['city'];
            $model->father_name = Yii::$app->request->post('User')['father_name'];
            $model->gender = Yii::$app->request->post('User')['gender'];
            $model->cnic = Yii::$app->request->post('User')['cnic'];
            $model->uni = Yii::$app->request->post('User')['uni'];
            $model->workplace = Yii::$app->request->post('User')['workplace'];
            
            $selectedSessions = Yii::$app->request->post('SignupForm')['register_for'];
            if ($selectedSessions) {
                $model->register_for = implode(',', $selectedSessions);
            }
            // Handle password change
            $newPassword = Yii::$app->request->post('User')['new_password'];
            if (!empty($newPassword)) {
                $model->setPassword($newPassword);  // Set password hash
            }

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'sessions' => $sessions,
            'getImages' => $getImages,
            'assignedSessions' => $assignedSessions,
            'attempted_quiz' => $attempted_quiz
        ]);
    }

    public function actionQuizresult($id)
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        $quiz = Quiz::findOne($id);
        $questions = $quiz->questions;
    }

    public function actionDeletestudentresponse()
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        $quizId = Yii::$app->request->get('qid');
        $studentId = Yii::$app->request->get('sid');

        // Ensure both `qid` and `sid` are provided
        if ($quizId && $studentId) {
            // Delete the student response
            StudentResponse::deleteAll(['quiz_id' => $quizId, 'student_id' => $studentId]);
            QuizTimeLog::deleteAll(['quiz_id' => $quizId, 'student_id' => $studentId]);
            Yii::$app->session->setFlash('success', 'Student allowed for re-attempt.');
        } else {
            // Set an error flash message if parameters are missing
            Yii::$app->session->setFlash('error', 'Invalid request parameters.');
        }

        // Redirect back to the referring page
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionAssignSession()
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        Yii::$app->response->format = Response::FORMAT_JSON;

        $userId = Yii::$app->request->post('user_id');
        $sessionId = Yii::$app->request->post('session_id');

        // Check if session is already assigned
        if (StudentSessionAssignment::find()->where(['student_id' => $userId, 'session_id' => $sessionId])->exists()) {
            return ['success' => false, 'message' => 'Session already assigned.'];
        }

        $assignment = new StudentSessionAssignment();
        $assignment->student_id = $userId;
        $assignment->session_id = $sessionId;

        if ($assignment->save()) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Failed to assign session.'];
    }

    public function actionRemoveSession()
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        Yii::$app->response->format = Response::FORMAT_JSON;

        $userId = Yii::$app->request->post('user_id');
        $sessionId = Yii::$app->request->post('session_id');

        $assignment = StudentSessionAssignment::findOne(['student_id' => $userId, 'session_id' => $sessionId]);

        if ($assignment && $assignment->delete()) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Failed to remove session.'];
    }

    public function actionLoadSessions($userId, $type = null)
    {
        $userId = intval($userId);
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($type == 'available') {
            $assignedSessionIds = StudentSessionAssignment::find()
                ->select('session_id')
                ->where(['student_id' => $userId])
                ->column();
            $sessions =  Session::find()->where(['not in', 'id', $assignedSessionIds])->orderBy(['created_at' => SORT_DESC]) // Sort by created_at in descending order
                ->limit(100) // Limit to 100 sessions
                ->all();
            // Prepare session data for response
            $sessionData = [];
            foreach ($sessions as $session) {
                $sessionData[] = [
                    'id' => $session->id,
                    'name' => $session->name,

                    'start_time' => date('Y-m-d H:i:s', strtotime($session->start_time)),
                    'end_time' => date('Y-m-d H:i:s', strtotime($session->end_time)),
                ];
            }

            return $this->asJson(['success' => true, 'sessions' => $sessionData]);
        }

        if ($type == 'assigned') {
            $assignedSessionIds = StudentSessionAssignment::find()
                ->select('session_id')
                ->where(['student_id' => $userId])
                ->column();

            $sessions =  Session::find()->where(['in', 'id', $assignedSessionIds])->orderBy(['created_at' => SORT_DESC]) // Sort by created_at in descending order
                ->limit(100) // Limit to 100 sessions
                ->all();

            // Prepare session data for response
            $sessionData = [];
            foreach ($sessions as $session) {
                $sessionData[] = [
                    'id' => $session->id,
                    'name' => $session->name,

                    'start_time' => date('Y-m-d H:i:s', strtotime($session->start_time)),
                    'end_time' => date('Y-m-d H:i:s', strtotime($session->end_time)),
                ];
            }

            return $this->asJson(['success' => true, 'sessions' => $sessionData]);
        }

        return 'no record found';
    }

    // Delete action to remove the user
    public function actionDelete($id)
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']); // Redirect back to the user list
    }

    // Helper function to find the model
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested user does not exist.');
    }
}
