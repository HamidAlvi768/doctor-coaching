<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use app\components\Helper;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Quiz Lectures';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="main-page">
    <div class="page-header">
        <h2><i class="fas fa-video"></i> <?= Html::encode($this->title) ?></h2>
    </div>
    <div class="page-content">
        <div class="lectures-container">
            <?php foreach ($videos as $video): ?>
                <?php
                $encryptedId = Yii::$app->security->encryptByKey($video->id, 'rmabsalibaig');
                $encryptedId = base64_encode($encryptedId);
                $encodedId = Helper::encodeId($video->id);
                $videoUrl = Url::to(["quiz/playvideo?session-id={$video->quiz->session->id}&id=$encodedId"]);
                ?>
                <div class="card video-card">
                    <div class="card-body">
                        <div class="video-item">
                            <div class="video-icon">
                                <a href="<?= $videoUrl ?>">
                                    <img src="<?= Yii::getAlias('@web/img/video-thumb.png') ?>" alt="Video Thumbnail" class="video-thumbnail">
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
                    </div>
                </div>
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
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .video-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .card-body {
        padding: 20px;
    }

    .video-item {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .video-icon {
        flex-shrink: 0;
    }

    .video-thumbnail {
        width: 200px;
        height: auto;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .video-icon:hover .video-thumbnail {
        transform: scale(1.05);
    }

    .video-details {
        max-width: 400px;
        flex: 1;
    }

    .video-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 500;
    }

    .video-link {
        color: #234262;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 0;
        transition: color 0.3s ease;
    }

    .video-link:hover {
        color: #2a5298;
        text-decoration: underline;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header h2 {
            font-size: 1.5rem;
        }

        .video-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .video-thumbnail {
            width: 150px;
        }

        .video-details {
            max-width: 100%;
        }

        .video-title {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 576px) {
        .main-page {
            padding: 10px;
        }

        .page-header {
            padding: 15px;
        }

        .video-thumbnail {
            width: 100%;
            max-width: 200px;
        }

        .video-item {
            gap: 15px;
        }

        .card-body {
            padding: 15px;
        }
    }
</style>