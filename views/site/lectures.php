<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use app\components\Helper;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Student Lectures';
$this->params['breadcrumbs'][] = $this->title;

// Register Font Awesome for icons
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css', ['position' => \yii\web\View::POS_HEAD]);
?>

<div class="main-page">
    <div class="page-header">
        <h2><i class="fas fa-video"></i> <?= Html::encode($this->title) ?></h2>
    </div>
    <div class="page-content">
        <div class="lectures-container">
            <?php foreach ($videos as $video): ?>
                <?php if ($video->quiz && $video->quiz->session): ?>
                    <?php
                    $encryptedId = Yii::$app->security->encryptByKey($video->id, 'rmabsalibaig');
                    $encryptedId = base64_encode($encryptedId);
                    $encodedId = Helper::encodeId($video->id);
                    $videoUrl = Url::to(["quiz/playvideo?session-id={$video->quiz->session->id}&id=$encodedId"]);
                    ?>
                    <div class="video-card">
                        <div class="video-thumbnail-container">
                            <a href="<?= $videoUrl ?>">
                                <img src="<?= Yii::getAlias('@web/img/video-thumb.png') ?>" alt="Video Thumbnail" class="video-thumbnail">
                                <div class="play-overlay"><i class="fas fa-play"></i></div>
                            </a>
                        </div>
                        <div class="video-details">
                            <h5 class="video-title">
                                <?= Html::a($video->title, $videoUrl, ['class' => 'video-link']) ?>
                            </h5>
                            <p class="video-meta"><strong>Session:</strong> <?= Html::encode($video->quiz->session->name) ?></p>
                            <p class="video-meta"><strong>Quiz:</strong> <?= Html::encode($video->quiz->title) ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
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

    .lectures-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .video-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        padding: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .video-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .video-thumbnail-container {
        position: relative;
        flex-shrink: 0;
    }

    .video-thumbnail {
        width: 200px;
        height: auto;
        border-radius: 8px;
        transition: opacity 0.3s ease;
    }

    .play-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50px;
        height: 50px;
        background: rgba(35, 66, 98, 0.7);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .video-thumbnail-container:hover .play-overlay {
        opacity: 1;
    }

    .video-thumbnail-container:hover .video-thumbnail {
        opacity: 0.8;
    }

    .video-details {
        flex: 1;
        padding-left: 15px;
    }

    .video-title {
        margin: 0 0 8px 0;
        font-size: 1.2rem;
        font-weight: 500;
    }

    .video-link {
        color: #234262;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .video-link:hover {
        color: #2a5298;
        text-decoration: underline;
    }

    .video-meta {
        margin: 4px 0;
        font-size: 0.95rem;
        color: #333;
    }

    .video-meta strong {
        color: #234262;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header h2 {
            font-size: 1.5rem;
        }

        .video-card {
            flex-direction: column;
            align-items: flex-start;
            padding: 12px;
        }

        .video-thumbnail-container {
            width: 100%;
        }

        .video-thumbnail {
            width: 100%;
            max-width: 300px;
            height: auto;
        }

        .play-overlay {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
            opacity: 0.8; /* Always visible on mobile for clarity */
        }

        .video-details {
            padding-left: 0;
            padding-top: 10px;
            width: 100%;
        }

        .video-title {
            font-size: 1.1rem;
        }

        .video-meta {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .main-page {
            padding: 15px;
        }

        .page-header {
            padding: 15px;
        }

        .lectures-container {
            gap: 15px;
        }

        .video-card {
            padding: 10px;
        }

        .video-thumbnail {
            max-width: 100%;
        }

        .play-overlay {
            width: 35px;
            height: 35px;
            font-size: 1rem;
        }

        .video-title {
            font-size: 1rem;
        }

        .video-meta {
            font-size: 0.85rem;
        }
    }
</style>