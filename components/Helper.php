<?php

namespace app\components;

use app\models\User;
use Yii;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Helper
{
    public static function generateOtpWithExpiry($length = 6, $expiryTime = 300) // Default expiry time is 5 minutes (300 seconds)
    {
        // Ensure the length is at least 4
        if ($length < 4) {
            $length = 6; // Set default length to 6 if an invalid length is provided
        }

        // Generate OTP as a random numeric string
        $otp = '';
        for ($i = 0; $i < $length; $i++) {
            $otp .= mt_rand(0, 9); // Append random digit between 0-9
        }

        // Get the local time zone from the Yii configuration
        $timeZone = Yii::$app->timeZone;

        // Set the default time zone to the application time zone
        date_default_timezone_set($timeZone);

        // Calculate expiration time (current time + expiry time in seconds)
        $expirationTime = date('Y-m-d H:i:s', time() + $expiryTime); // Store in DATETIME format

        return [
            'otp' => $otp,
            'expiry' => $expirationTime
        ];
    }

    public static function expireTime($expiryTime = 0)
    {
        // Get the local time zone from the Yii configuration
        $timeZone = Yii::$app->timeZone;

        // Set the default time zone to the application time zone
        date_default_timezone_set($timeZone);

        // Calculate expiration time (current time + expiry time in seconds)
        $expirationTime = date('Y-m-d H:i:s', time() + $expiryTime);
        return $expirationTime;
    }

    public static function checkTimeAndLogout()
    {
        // Logout the user if they are logged in
        if (!Yii::$app->user->isGuest) {

            $sessionUser = User::find()->where(['session_id' => Yii::$app->session->getId()])->one();
            if (!$sessionUser) {
                Yii::$app->user->logout();
                // Destroy the session
                Yii::$app->session->destroy();
                return true;
            }

            $user = User::findOne(Yii::$app->user->identity->id);
            $currentTime = date('Y-m-d H:i:s');
            if ($user && strtotime($currentTime) > strtotime($user->timeout)) {
                $user->timeout = null;
                $user->save();
                Yii::$app->user->logout();

                // Destroy the session
                Yii::$app->session->destroy();
                return true;
            }
            return false;
        }
    }

    public static function checkUserLoginAndValidate()
    {
        if (Yii::$app->user->isGuest) {
            return true;
        }
        return false;
    }
    public static function getFolderSize($path)
    {
        $totalSize = 0;
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $totalSize += $file->getSize(); // Add file size
            }
        }

        return $totalSize;
    }

    public static function encodeId($serial) {
        $base36 = base_convert($serial, 10, 36); // Convert to base-36 (0-9, a-z)
        $chars = str_split($base36);
        shuffle($chars); // Randomize order
        $encodedCore = 'x' . implode('', $chars); // Core encoded part with prefix 'x'
        
        // Generate random padding to reach 30 characters
        $paddingLength = 30 - strlen($encodedCore) - 1; // -1 for delimiter
        $padding = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, $paddingLength);
        
        return $encodedCore . '-' . $padding; // Use '-' as delimiter
    }
    
    public static function decodeId($encoded) {
        if (strlen($encoded) !== 30) {
            return false; // Invalid length
        }
        
        // Split at delimiter to get the core encoded part
        $parts = explode('-', $encoded);
        if (count($parts) !== 2) {
            return false; // Invalid format
        }
        
        $stripped = substr($parts[0], 1); // Remove prefix 'x' from core
        $chars = str_split($stripped);
        sort($chars); // Reverse shuffle by sorting
        $base36 = implode('', $chars);
        return base_convert($base36, 36, 10); // Back to decimal
    }
}
