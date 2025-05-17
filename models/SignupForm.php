<?php

namespace app\models;

use app\components\Helper;
use yii\base\Model;
use app\models\User;
use Yii;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $register_for;
    public $full_name;
    public $father_name;
    public $cnic;
    public $gender;
    public $uni;
    public $workplace;
    
    public $number;
    public $city;
    public $captcha;
    public $terms_accepted; // Added Terms and Conditions field

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            [['full_name','father_name','cnic','gender','uni','workplace', 'number', 'email', 'register_for', 'city', 'captcha', 'terms_accepted'], 'required'], // Added terms_accepted to required fields
            [['register_for', 'full_name', 'number', 'city'], 'safe'],

            // CAPTCHA validation
            ['captcha', 'captcha', 'captchaAction' => 'site/captcha'],

            // Terms and Conditions validation
            ['terms_accepted', 'boolean'],
            ['terms_accepted', 'compare', 'compareValue' => 1, 'message' => 'You must accept the Terms and Conditions to sign up.'],
        ];
    }

    public function signup()
    {
        $this->username = $this->email;

        // Create a new User instance
        $user = new User();
        $user->username = $this->email;
        $user->email = $this->email;
        $user->full_name = $this->full_name;
        $user->number = $this->number;
        $user->cnic = $this->cnic;
        $user->gender = $this->gender;
        $user->father_name = $this->father_name;
        $user->uni = $this->uni;
        $user->workplace = $this->workplace;
        $user->register_for = is_array($this->register_for) ? implode(',', $this->register_for) : $this->register_for;
        $user->city = $this->city;
        $user->setPassword($this->password);
        $user->otp = Helper::generateOtpWithExpiry()['otp'];
        $user->otp_expire = Helper::generateOtpWithExpiry()['expiry'];
        $user->generateAuthKey();

        if (!$this->validate()) {
            return null;
        }

        // Save the user and return the result
        return $user->save() ? $user : null;
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'full_name' => 'Full Name',
            'number' => 'Contact Number',
            'city' => 'City',
            'captcha' => 'Verification Code',
            'register_for' => 'Register For',
            'terms_accepted' => 'Terms and Conditions', // Label for the checkbox
        ];
    }
}
