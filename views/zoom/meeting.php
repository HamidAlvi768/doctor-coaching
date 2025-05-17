<?php

/** @var yii\web\View $this */
/** @var app\models\Stream $stream */

use yii\bootstrap5\Html;
use yii\helpers\Url;

use function PHPSTORM_META\type;

$this->title = 'Live Stream';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .logo {
        position: fixed;
        top: 15px;
        left: 15px;
        z-index: 9999;

    }

    .user-info {
        text-align: center;
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
    }
</style>
<div class="user-info">
    <p><strong>Name: </strong><span><?= Yii::$app->user->identity->full_name ?></span></p>
    <p><strong>Email: </strong><span><?= Yii::$app->user->identity->email ?></span></p>
    <p><strong>Number: </strong><span><?= Yii::$app->user->identity->number ?></span></p>
</div>
<div class="main-page">
    <div class="page-content">
        <div class="live-stream-video-container">
            <?php if ($stream): ?>
                <?php if ($stream->stream_type == "zoom"): ?>
                    <div class="live-stream-container">
                        <div id="meetingSDKElement" style="">
                            <!-- Zoom Meeting will load here -->
                            <div class="container tex">
                                <h3>Wait...</h3>
                            </div>
                        </div>
                    </div>
                    <?php
                    $username = Yii::$app->user->identity->username;
                    $email = Yii::$app->user->identity->email;
                    $leavUrl = Url::to(['site/live-stream'], true);
                    $signatureUrl = Url::to(['zoom/signature?=meetingNumber=' . $stream->meeting_id . '&role=0'], true);
                    ?>

                    <?php
                    // Register Zoom-specific CSS and JS
                    $this->registerCssFile('https://source.zoom.us/3.8.0/css/bootstrap.css');
                    $this->registerCssFile('https://source.zoom.us/3.8.0/css/react-select.css');

                    $this->registerJsFile('https://source.zoom.us/3.8.0/lib/vendor/react.min.js', ['position' => \yii\web\View::POS_END]);
                    $this->registerJsFile('https://source.zoom.us/3.8.0/lib/vendor/react-dom.min.js', ['position' => \yii\web\View::POS_END]);
                    $this->registerJsFile('https://source.zoom.us/3.8.0/lib/vendor/redux.min.js', ['position' => \yii\web\View::POS_END]);
                    $this->registerJsFile('https://source.zoom.us/3.8.0/lib/vendor/redux-thunk.min.js', ['position' => \yii\web\View::POS_END]);
                    $this->registerJsFile('https://source.zoom.us/3.8.0/lib/vendor/lodash.min.js', ['position' => \yii\web\View::POS_END]);
                    $this->registerJsFile('https://source.zoom.us/zoom-meeting-3.8.0.min.js', ['position' => \yii\web\View::POS_END]);

                    // Zoom meeting configuration and initialization
                    $zoomJs = <<<JS
                            ZoomMtg.setZoomJSLib('https://source.zoom.us/3.8.0/lib', '/av');
                            ZoomMtg.preLoadWasm();
                            ZoomMtg.prepareWebSDK();

                            function startMeeting(signature) {
                                const meetingConfig = {
                                    signature: signature,
                                    sdkKey: '9_rlA9PqQSaSomqZp5ivw', // Replace with your actual SDK key
                                    meetingNumber: '{$stream->meeting_id}', // Assuming this is a property in your Stream model
                                    passWord: '{$stream->meeting_passcode}', // Assuming this is a property in your Stream model
                                    userName: '{$username}', // Replace with the actual username
                                    userEmail: '{$email}',
                                    leaveUrl: '{$leavUrl}',
                                    role: 0
                                };

                                ZoomMtg.init({
                                    leaveUrl: meetingConfig.leaveUrl,
                                    success: function() {
                                        ZoomMtg.join({
                                            signature: meetingConfig.signature,
                                            sdkKey: meetingConfig.sdkKey,
                                            meetingNumber: meetingConfig.meetingNumber,
                                            userName: meetingConfig.userName,
                                            passWord: meetingConfig.passWord,
                                            userEmail: meetingConfig.userEmail,
                                            success: function(res) {
                                                console.log('Meeting joined successfully:', res);
                                                const dWrappers=document.querySelectorAll(".meeting-info-container__wrapper");
                                                if(dWrappers[0]){dWrappers[0].remove();}
                                                setTimeout(() => {
                                                    const dWrappers=document.querySelectorAll(".meeting-info-container__wrapper");
                                                    if(dWrappers[0]){dWrappers[0].remove();}
                                                }, 0);
                                            },
                                            error: function(res) {
                                                console.error('Error joining meeting:', res);
                                            }
                                        });
                                    },
                                    error: function(res) {
                                        console.error('Error initializing Zoom:', res);
                                    }
                                });
                            }

                            // Fetch signature from your server
                            fetch('{$signatureUrl}')
                                .then(response => response.json())
                                .then(data => {
                                    startMeeting(data.signature);
                                })
                                .catch(error => console.error('Error fetching signature:', error));
                    JS;
                    $this->registerJs($zoomJs, \yii\web\View::POS_END);
                    ?>

                <?php endif; ?>
            <?php else: ?>
                <div class="container">
                    <p><strong>There is no Live Stream scheduled yet.</strong></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .main-page {
        width: 100%;
        padding: 20px;
        font-family: 'Poppins', sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, #234262, #2a5298);
        color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .page-header h2 {
        font-size: 1.8rem;
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-content {
        width: 100%;
    }

    .stream-details {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .stream-details h3 {
        font-size: 1.5rem;
        color: #234262;
        margin-bottom: 15px;
    }

    .stream-details p {
        font-size: 1.1rem;
        margin: 5px 0;
    }

    .stream-details strong {
        color: #2a5298;
    }

    .live-stream-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    #stream-iframe {
        width: 100%;
        height: 100%;
        border-radius: 5px;
    }

    .container {
        text-align: center;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    #remaining-time,
    #stream-status {
        color: #e94560;
        font-weight: 500;
    }
</style>



<?php if ($stream): ?>
    <?php

    $this->registerJs(<<<JS
        // Prevent right-click
        document.addEventListener('contextmenu', event => {
            event.preventDefault();
            // changeContent();
        });
        
        function userInfo(){
            const userInfo = document.querySelector('.user-info');
            const showDuration = 30 * 1000; // 30 seconds
            const hideDuration = 10*60 * 1000; // 10 minutes

            function toggleUserInfo() {
                // Show info
                userInfo.style.display = 'block';
                setTimeout(() => {
                    // Hide info
                    userInfo.style.display = 'none';
                    setTimeout(toggleUserInfo, hideDuration);
                }, showDuration);
            }

            // Start the loop
            toggleUserInfo();
        }
        userInfo();

    JS, \yii\web\View::POS_END);
    ?>
<?php endif; ?>