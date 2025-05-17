<?php

namespace app\components;

use Yii;

class Mail
{
    public static function SendVerificationMail($user)
    {
        try {
            return Yii::$app->mailer->compose('verification-email', [
                'user' => $user
            ])
                ->setTo($user->email)
                ->setFrom(['admin@drcoachingacademy.com' => 'Doctors Coaching Academy'])
                ->setSubject('Verify your email address')
                ->send();
        } catch (\Exception $e) {
            Yii::error('Failed to send verification email: ' . $e->getMessage());
            return false;
        }
    }

    public static function SendResetEmail($user, $newPassword)
    {
        try {
            return Yii::$app->mailer->compose('reset-password-email', [
                'user' => $user,
                'newPassword' => $newPassword
            ])
                ->setTo($user->email)
                ->setFrom(['admin@drcoachingacademy.com' => 'Doctors Coaching Academy'])
                ->setSubject('New Password')
                ->send();
        } catch (\Exception $e) {
            Yii::error('Failed to send reset email: ' . $e->getMessage());
            return false;
        }
    }
}
