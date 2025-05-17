<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_session_assignment".
 *
 * @property int $id
 * @property int $student_id
 * @property int $session_id
 * @property string|null $assigned_at
 */
class StudentSessionAssignment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_session_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'session_id'], 'required'],
            [['student_id', 'session_id'], 'integer'],
            [['assigned_at'], 'safe'],
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
            'session_id' => 'Session ID',
            'assigned_at' => 'Assigned At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return StudentSessionAssignmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StudentSessionAssignmentQuery(get_called_class());
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getSession()
    {
        return $this->hasOne(Session::class, ['id' => 'session_id']);
    }

}
