<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$profileUrl = Url::to(['site/profile']);
$this->title = 'Student Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="card card-primary  mt-5 mb-5">
        <div class="card-header">
            <h4>Subscribed sessions
                <a class="btn btn-link" style="float:right;" href="<?= $profileUrl ?>">User Profile</a>
            </h4>

        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>
                            sr #
                        </th>
                        <th style="width:70%;">
                            session name
                        </th>
                        <th>
                            schedule
                        </th>
                    </tr>
                    <?php $n = 1;
                    foreach ($model->sessions as $session) {
                    ?>
                        <tr>
                            <td>
                                <?= $n; ?>
                            </td>
                            <td>
                                <?= Html::a($session->name, ['site/quizlist', 'id' => $session->id], [
                                    'class' => 'btn btn-link',
                                    // Assuming the quiz ID is available here
                                ]); ?>

                                <br>
                                <span style="font-size:smaller;"><?= $session->description; ?></span>
                            </td>
                            <td>
                                <?= date('d M y', strtotime($session->start_time)) . ' - ' . date('d M y', strtotime($session->end_time)) ?>

                            </td>
                        </tr>
                    <?php
                        $n++;
                    } ?>

                </thead>
            </table>
        </div>
    </div>
</div>