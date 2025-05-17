<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Online Quizzes';
?>
<style>
    .breadcam_bg {
        background-image: url(../img/banner/exam.jpg) !important;
    }

    .recent_event_area .single_event .date {
        background: #31d6a8 !important;
    }
</style>
<div class="bradcam_area breadcam_bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="bradcam_text">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="recent_event_area section__padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="section_title text-center mb-70">
                    <h3 class="mb-45">Current Quizzes Available</h3>
                    <p>Join our latest medical sessions to enhance your skills and knowledge with experts from the industry.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <?php foreach ($quizes as $quiz): ?>
                    <?php
                    $sessionId = $quiz->session->id ?? 0;
                    ?>
                    <div class="single_event d-flex align-items-center">
                        <div class="date text-center">
                            <span><?= date('d', strtotime($quiz->start_at)) ?></span>
                            <p><?= date('M, Y', strtotime($quiz->start_at)) ?></p>
                        </div>
                        <div class="event_info">

                            <h4><?= Html::encode($quiz->title) ?></h4>
                            <p><span><i class="flaticon-placeholder"></i> Islamabad / Online</span></p>
                            <?php if (Yii::$app->user->isGuest): ?>
                                <p><a class="text-danger" href="<?= \yii\helpers\Url::to(['/site/login']) ?>">login</a> to view</p>
                            <?php elseif (!Yii::$app->user->isGuest): ?>
                                <p><a class="text-success" href="<?= \yii\helpers\Url::to(["quiz/attempt-now?id={$quiz->id}&session={$sessionId}"]) ?>">View Now</a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>


            </div>

        </div>
    </div>
</div>