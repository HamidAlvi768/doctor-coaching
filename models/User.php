<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
    public static function findByNumber($number)
    {
        return static::findOne(['number' => $number]);
    }
    public static function findByCity($city)
    {
        return static::findOne(['city' => $city]);
    }
    public static function findByFull_name($full_name)
    {
        return static::findOne(['full_name' => $full_name]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    // Relation to get all sessions assigned to the user
    public function getSessions()
    {
        return $this->hasMany(Session::class, ['id' => 'session_id'])
            ->viaTable('student_session_assignment', ['student_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);
    }
}
