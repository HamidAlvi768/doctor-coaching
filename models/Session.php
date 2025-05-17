<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "session".
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $name
 * @property string|null $description
 * @property string $start_time
 * @property string $end_time
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string $status
 */
class Session extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_time', 'end_time'], 'required'],
            [['start_time', 'end_time', 'created_at', 'updated_at'], 'safe'],
            [['type', 'status'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'description' => 'Description',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SessionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SessionQuery(get_called_class());
    }

    // Relation to get all users assigned to this session
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'student_id'])
            ->viaTable('student_session_assignment', ['session_id' => 'id']);
    }
    public function getQuizlist()
    {
        return $this->hasMany(Quiz::class, ['session_id' => 'id']);
    }
}
