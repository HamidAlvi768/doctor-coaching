<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_response".
 *
 * @property int $id
 * @property int $student_id
 * @property int $question_id
 * @property int|null $answer_id
 * @property int $session_id
 * @property string|null $submitted_at
 */
class StudentResponse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_response';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'question_id', 'session_id'], 'required'],
            [['student_id', 'question_id', 'answer_id', 'session_id'], 'integer'],
            [['submitted_at'], 'safe'],
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
            'question_id' => 'Question ID',
            'answer_id' => 'Answer ID',
            'session_id' => 'Session ID',
            'submitted_at' => 'Submitted At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return StudentResponseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StudentResponseQuery(get_called_class());
    }

    public function getQuiz(){
        return $this->hasOne(Quiz::class, ['id' => 'quiz_id']);
    }

    public function getStudent(){
        return $this->hasOne(User::class, ['id' => 'student_id']);
    }

    public function getQuestion(){
        return $this->hasOne(Question::class, ['id' => 'question_id']);
    }

    public function getAnswer(){
        return $this->hasOne(Answer::class, ['id' => 'answer_id']);
    }
    public function getSession(){
        return $this->hasOne(Session::class, ['id' => 'session_id']);
    }
}
