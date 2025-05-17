<?php
/* @var $this yii\web\View */
/* @var $videoUrl string */

use yii\helpers\Html;

?>

<style>
    .video-container {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 0px;
        position: relative;
    }

    .video-container video {
        width: 600px;
        max-width: 100%;
        border-radius: 5px;
    }

    .email-overlay {
        width: 100%;
        position: absolute;
        text-align: center;
        margin-top: 200px;
        z-index: 1;
        pointer-events: none;
    }

    .email-overlay p {
        color: #234262;
        font-weight: 600;
        opacity: 0.6;
        pointer-events: none;
    }

    .screenshot-blocker {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0);
        /* Transparent by default */
        z-index: 9999;
        pointer-events: none;
    }
</style>

<div class="video-container">
    <video width="600" id="video" style="width: 100%;" preload="auto" playsinline controls controlsList="nodownload nofullscreen" disablePictureInPicture>
        <source src="<?= Html::encode($videoUrl) ?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="email-overlay">
        <p>Email: <?= Html::encode(Yii::$app->user->identity->email); ?></p>
        <p>CNIC: <?= Html::encode(Yii::$app->user->identity->cnic); ?></p>
        <p>Number: <?= Html::encode(Yii::$app->user->identity->number); ?></p>
    </div>
    <div class="screenshot-blocker" id="screenshot-blocker"></div>
</div>

<?php
$this->registerJsFile('https://code.jquery.com/jquery-3.6.0.min.js', ['position' => \yii\web\View::POS_HEAD]);

$js = <<<JS
    // Disable right-click
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    // Disable drag and drop
    document.querySelector('video').addEventListener('dragstart', function(e) {
        e.preventDefault();
    });

    // Enhanced screenshot prevention
    function blockScreenshot() {
        var blocker = $('#screenshot-blocker');
        
        // Desktop: PrintScreen, Alt+PrintScreen, Ctrl+P
        $(document).on('keydown', function(e) {
            if (e.key === 'PrintScreen' || 
                (e.altKey && e.key === 'Print') || 
                (e.ctrlKey && e.key === 'P')) {
                blocker.css('background', 'rgba(255, 0, 0, 0.8)');
                setTimeout(() => blocker.css('background', 'rgba(0, 0, 0, 0)'), 100);
                if (navigator.clipboard) {
                    navigator.clipboard.writeText('Screenshots are not allowed!').then(function() {
                        alert('Screenshots are not allowed on this page!');
                    });
                } else {
                    alert('Screenshots are not allowed on this page!');
                }
                e.preventDefault();
            }
        });

        // Mobile: Attempt to detect screenshot via visibility/focus changes (imperfect)
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                setTimeout(() => {
                    if (!document.hidden) { // User returned quickly, possible screenshot
                        blocker.css('background', 'rgba(255, 0, 0, 0.8)');
                        setTimeout(() => blocker.css('background', 'rgba(0, 0, 0, 0)'), 100);
                        alert('Screenshots are not allowed on this page!');
                    }
                }, 500); // Delay to catch quick tab switches
            }
        });

        // Disable other keyboard shortcuts
        $(document).on('keydown', function(e) {
            if (e.keyCode == 123 || // F12
                (e.ctrlKey && e.shiftKey && e.keyCode == 73) || // Ctrl+Shift+I
                (e.ctrlKey && e.shiftKey && e.keyCode == 74) || // Ctrl+Shift+J
                (e.ctrlKey && e.keyCode == 85) || // Ctrl+U
                (e.ctrlKey && e.keyCode == 83)) { // Ctrl+S
                e.preventDefault();
            }
        });
    }
    blockScreenshot();

    // Detect developer tools
    (function() {
        const threshold = 160;
        let lastWidth = window.outerWidth - window.innerWidth > threshold;
        let lastHeight = window.outerHeight - window.innerHeight > threshold;

        window.addEventListener('resize', function() {
            let devtoolsOpened = (
                window.outerWidth - window.innerWidth > threshold ||
                window.outerHeight - window.innerHeight > threshold
            );
            if (devtoolsOpened && (!lastWidth || !lastHeight)) {
                alert('Developer tools are open. Closing the page!');
                window.location.href = 'about:blank'; // Redirect instead of close
            }
            lastWidth = window.outerWidth - window.innerWidth > threshold;
            lastHeight = window.outerHeight - window.innerHeight > threshold;
        });
    })();
JS;

$this->registerJs($js, \yii\web\View::POS_END);
?>