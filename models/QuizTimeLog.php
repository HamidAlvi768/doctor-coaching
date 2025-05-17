<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quiz_time_log".
 *
 * @property int $id
 * @property int $quiz_id
 * @property int $student_id
 * @property int $total_time
 * @property int $spend_time
 * @property string $created_at
 * @property string $updated_at
 */
class QuizTimeLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quiz_time_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_id', 'student_id', 'total_time', 'spend_time'], 'required'],
            [['quiz_id', 'student_id', 'total_time', 'spend_time'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quiz_id' => 'Quiz ID',
            'student_id' => 'Student ID',
            'total_time' => 'Total Time',
            'spend_time' => 'Spend Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return QuizTimeLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuizTimeLogQuery(get_called_class());
    }
}
