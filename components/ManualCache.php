<?php

namespace app\components;

use app\models\StudentResponse;
use Yii;
use yii\base\Component;
use yii\helpers\Json;

class ManualCache extends Component
{
    public static $cacheFilePath = "@runtime/cache/submissions.json";

    /**
     * Get current cache data
     */
    public static function getCacheData()
    {
        $filePath = Yii::getAlias(self::$cacheFilePath);

        if (!file_exists($filePath)) {
            return [];
        }

        $content = file_get_contents($filePath);
        return $content ? Json::decode($content, true) : [];
    }

    /**
     * Save data to cache file
     */
    public static function saveCacheData($data)
    {
        $filePath = Yii::getAlias(self::$cacheFilePath);

        // Ensure directory exists
        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents($filePath, Json::encode($data), LOCK_EX);
    }
    public static function processAllCache()
    {
        $cacheData = ManualCache::getCacheData();

        if (empty($cacheData)) {
            return true;
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

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();

            return false;
        }
    }

    public static function processStudentCache($studentId)
    {
        $cacheData = ManualCache::getCacheData();
        $cacheData = array_filter($cacheData, function ($submission) use ($studentId) {
            return $submission['student_id'] == $studentId;
        });

        if (empty($cacheData)) {
            return true;
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

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();

            return false;
        }
    }

    public static function processStudentRemainingCache()
    {
        $cacheData = self::getCacheData();
        $studentId = Yii::$app->user->identity->id; // Get the logged-in user's ID
        $cacheData = array_filter($cacheData, function ($submission) use ($studentId) {
            return $submission['student_id'] == $studentId;
        });
        if (count($cacheData) > 0) {
            ManualCache::processStudentCache($studentId);
        }
    }
}
