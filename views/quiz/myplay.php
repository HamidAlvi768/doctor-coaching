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

