<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Video extends ActiveRecord
{
    public static function tableName()
    {
        return 'videos';
    }

    public function rules()
    {
        return [
            [['title', 'name'], 'string', 'max' => 255],
            [['file_path'], 'string', 'max' => 255],
            [['quiz_id'], 'number'],
            [['file_path'], 'file', 'extensions' => 'mp4'], // 100 MB limit
        ];
    }
    public function getQuiz()
    {
        return $this->hasOne(Quiz::class, ['id' => 'quiz_id']);
    }
}
