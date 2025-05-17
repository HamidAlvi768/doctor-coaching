<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class UserImages extends ActiveRecord
{
    // Define the table name if it's different from the default naming convention
    public static function tableName()
    {
        return 'user_images';
    }

    // Define rules for validation
    public function rules()
    {
        return [
            [['user_id', 'file_path'], 'required'],
            [['user_id'], 'integer'],
            [['file_path'], 'string', 'max' => 255],
            [['created_at'], 'safe'], // Allow safe for created_at to enable timestamp management
        ];
    }

    // Define attribute labels for the model
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'file_path' => 'File Path',
            'created_at' => 'Created At',
        ];
    }

    // Define a relation to the User model (assuming you have a User model)
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
