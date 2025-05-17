<?php

namespace app\controllers;

use app\components\Helper;
use app\models\Stream;
use Yii;
use yii\web\Controller;

use Firebase\JWT\JWT;

class ZoomController extends Controller
{
    // Your Zoom Client ID and Secret from Zoom App Marketplace
    private $clientId = '9_rlA9PqQSaSomqZp5ivw';
    private $clientSecret = '8Nl97v7S9cbx9TS5HWaoU7qeYJmiFohB';
    private $redirectUri = 'https://drcoachingacademy.com/testing/testing/zoom/oauth-callback';

    public function actionOauthCallback()
    {
        // Get the authorization code from Zoom
        $code = Yii::$app->request->get('code');

        if ($code) {
            // Exchange code for access token
            $tokenUrl = 'https://zoom.us/oauth/token';
            $params = [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $this->redirectUri,
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $tokenUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
            ]);
            $response = curl_exec($ch);
            curl_close($ch);

            $tokenData = json_decode($response, true);

            if (isset($tokenData['access_token'])) {
                // Store the token (e.g., in session or DB) if needed
                Yii::$app->session->set('zoom_access_token', $tokenData['access_token']);

                // Redirect to your meeting view page
                return $this->redirect(['site/live-stream']);
            } else {
                // Handle error (e.g., log it or show message)
                return $this->render('error', ['message' => 'Failed to get access token']);
            }
        }

        return $this->render('error', ['message' => 'No authorization code received']);
    }

    public function actionMeeting()
    {
        if (Helper::checkUserLoginAndValidate()) {
            return $this->redirect(['site/login']);
        }
        // if (Yii::$app->user->identity->usertype == 'student' && Yii::$app->user->identity->fee_paid == 'no') {
        //     $m = 'cannot continue, your fee status is not marked "paid", if you paid fee please contact our admin at <span style="font-weight:600;">admin@drcoachingacademy.com</span> or <span style="font-weight:600;">03365359967</span> to resolve issue';
        //     $this->redirect(['site/dashboard', 'message' => $m]);
        // }

        $stream = Stream::find()->one();

        // Simple meeting view page (you can embed Zoom here)
        return $this->render('meeting', [
            'stream' => $stream,
        ]);
    }

    public function actionSignature()
    {
        // Replace these with your Zoom Marketplace credentials
        $sdkKey = '9_rlA9PqQSaSomqZp5ivw';       // From Zoom Marketplace
        $sdkSecret = '8Nl97v7S9cbx9TS5HWaoU7qeYJmiFohB'; // From Zoom Marketplace


        // Get meeting number and role from request (adjust based on your Stream model or params)
        $meetingNumber = Yii::$app->request->get('meetingNumber', '');
        $stream = Stream::find()->one();
        if ($stream && $stream->meeting_id) {
            $meetingNumber = $stream->meeting_id;
        }

        // Get meeting number and role from request (adjust based on your Stream model or params) // Default for testing
        $role = Yii::$app->request->get('role', 0); // Default to attendee (0)

        // Generate the signature
        $signature = $this->generateZoomSignature($sdkKey, $sdkSecret, $meetingNumber, $role);

        // Return JSON response
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->headers->add('Access-Control-Allow-Origin', '*'); // Optional, for CORS

        return ['signature' => $signature];
    }

    /**
     * Generates a Zoom signature using JWT.
     * @param string $sdkKey Zoom SDK Key
     * @param string $sdkSecret Zoom SDK Secret
     * @param string $meetingNumber Zoom Meeting Number
     * @param int $role Role (0 = attendee, 1 = host)
     * @return string Generated JWT signature
     */
    private function generateZoomSignature($sdkKey, $sdkSecret, $meetingNumber, $role)
    {
        $iat = time() - 30; // Issued at time (current time minus 30 seconds)
        $exp = $iat + 60 * 60 * 2; // Expiration time (2 hours from now)

        $payload = [
            'sdkKey' => $sdkKey,
            'mn' => $meetingNumber,
            'role' => $role,
            'iat' => $iat,
            'exp' => $exp,
            'tokenExp' => $exp
        ];

        return JWT::encode($payload, $sdkSecret, 'HS256');
    }
}
