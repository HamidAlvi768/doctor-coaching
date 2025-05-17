<?php

namespace app\controllers;

use app\components\Helper;
use app\components\ManualCache;
use Yii;
use app\models\News;
use app\models\NewsSearch;
use app\models\StudentResponse;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * NewsController implements the CRUD actions for News model.
 */
class CacheController extends Controller
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
     * View current cache contents
     */
    public function actionViewCache()
    {
        $cacheData = ManualCache::getCacheData();

        return $this->asJson([
            'success' => true,
            'data' => $cacheData,
            'count' => count($cacheData)
        ]);
    }
    /**
     * Process cached data to database
     */
    public function actionProcessCache()
    {
        $cacheData = ManualCache::getCacheData();

        if (empty($cacheData)) {
            return $this->asJson([
                'success' => true,
                'message' => 'No cached data to process'
            ]);
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            foreach ($cacheData as $index => $submission) {
                $model = new StudentResponse(); // Replace with your model

                $model->quiz_id = $submission['quiz_id'] ?? null;
                $model->session_id = $submission['session_id'] ?? null;
                $model->student_id = $submission['student_id'] ?? null;
                $model->question_id = $submission['question_id'] ?? null;
                $model->student_answer = $submission['student_answer'] ?? null;
                $model->answer_id = $submission['answer_id'] ?? null;
                $model->submitted_at = $submission['submitted_at'] ?? null;
                $model->created_at = date('Y-m-d H:i:s', $submission['timestamp'] ?? time());

                $alreadyExists = StudentResponse::findOne(['student_id' => $model->student_id, 'question_id' => $model->question_id]);
                if (!$alreadyExists) {
                    if (!$model->save()) {
                        throw new \Exception('Failed to save submission: ' . Json::encode($model->errors));
                    }
                }

                // Remove processed item from cache
                unset($cacheData[$index]);
            }

            // Update cache file with remaining items (if any)
            ManualCache::saveCacheData($cacheData);

            $transaction->commit();

            return $this->asJson([
                'success' => true,
                'message' => 'Cache processed successfully'
            ]);
        } catch (\Exception $e) {
            $transaction->rollBack();

            return $this->asJson([
                'success' => false,
                'message' => 'Error processing cache: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Submit data to JSON cache
     */
    public function actionSubmit()
    {
        $request = Yii::$app->request;
        // if ($request->isPost) {
        $data = [
            'name' => "John Doe",
            'email' => "johndoe@gmail.com",
            'phone' => "1234567890",
            'message' => "Hello, this is a test message.",
            'timestamp' => time(),
        ];

        // Get existing cache data
        $cacheData = ManualCache::getCacheData();

        // Add new submission with timestamp
        $submission = [
            'id' => uniqid(), // Unique identifier for each submission
            'data' => $data,
            'timestamp' => time(),
        ];

        $cacheData[] = $submission;

        // Save to JSON file
        ManualCache::saveCacheData($cacheData);

        return $this->asJson([
            'success' => true,
            'message' => 'Data cached successfully',
            'submission_id' => $submission['id']
        ]);
        // }

        return $this->asJson([
            'success' => false,
            'message' => 'Invalid request method'
        ]);
    }
}
