<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quiz".
 *
 * @property int $id
 * @property int $session_id
 * @property string $title
 * @property string|null $description
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Quiz extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quiz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['session_id', 'title', 'start_at', 'end_at', 'duration_in_minutes'], 'required'],
            [['session_id', 'duration_in_minutes'], 'integer'],
            [['description'], 'string'],
            [['start_at', 'end_at'], 'datetime', 'format' => 'php:Y-m-d\TH:i'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'session_id' => 'Session ID',
            'title' => 'Title',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return QuizQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuizQuery(get_called_class());
    }

    public function getQuestions()
    {
        return $this->hasMany(Question::class, ['quiz_id' => 'id']);
    }
    public function getSession()
    {
        return $this->hasOne(Session::class, ['id' => 'session_id']);
    }
    public function getVideos()
    {
        return $this->hasMany(Video::class, ['quiz_id' => 'id']);
    }
    public function getStudentresponses()
    {
        return $this->hasMany(StudentResponse::class, ['quiz_id' => 'id', 'student_id' => Yii::$app->user->id]);
    }
}
