<?php
/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $verificationLink string The verification link that the user needs to click */

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style type="text/css">
        body,
        table,
        td,
        a {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            text-size-adjust: 100%;
        }

        table {
            border-collapse: collapse;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .email-container {
            width: 100%;
            background-color: #f8f8f8;
            padding: 40px 0;
        }

        .email-content {
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background-color: #234262;
            text-align: center;
            padding: 40px;
            border-radius: 8px 8px 0 0;
            color: white;
        }

        .email-body {
            padding: 40px;
            text-align: center;
        }

        .email-footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777777;
            background-color: #f1f1f1;
            border-radius: 0 0 8px 8px;
        }

        .button {
            background-color: #234262;
            color: white;
            padding: 15px 25px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }

        .button:hover {
            background-color: #234262;
        }

        @media only screen and (max-width: 600px) {
            .email-content {
                padding: 10px;
            }

            .email-header {
                padding: 20px;
            }

            .email-body {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <table role="presentation" class="email-content">
            <tr>
                <td class="email-header">
                    <h1>Welcome to Doctors Coaching Academy</h1>
                </td>
            </tr>
            <tr>
                <td class="email-body">
                    <h2>Email Verification</h2>
                    <p>Hi <?= $user->username ?>,</p>
                    <p>Thank you for signing up with us! To complete your registration, please verify your email address by otp:</p>
                    <p><strong style="font-size: 2rem;"><?= $user->otp ?></strong></p>
                    <p>If you didn't sign up for an account, you can safely ignore this email.</p>
                </td>
            </tr>
            <tr>
                <td class="email-footer">
                    <p>© <?= date('Y') ?> Doctors Coaching Academy. All Rights Reserved.</p>
                    <p>If you have any questions, feel free to <a href="mailto:admin@drcoachingacademy.com">contact our support team</a>.</p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>