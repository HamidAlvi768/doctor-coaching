<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reattempts".
 *
 * @property int $id
 * @property int|null $student_id
 * @property int|null $quiz_id
 * @property string $reason
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class Reattempts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reattempts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'quiz_id', 'status'], 'integer'],
            [['reason'], 'required'],
            [['reason'], 'string'],
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
            'student_id' => 'Student ID',
            'quiz_id' => 'Quiz ID',
            'reason' => 'Reason',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ReattemptsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReattemptsQuery(get_called_class());
    }
    public function getStudent()
    {
        return $this->hasOne(User::class, ['id' => 'student_id']);
    }
    public function getQuiz()
    {
        return $this->hasOne(Quiz::class, ['id' => 'quiz_id']);
    }
}
