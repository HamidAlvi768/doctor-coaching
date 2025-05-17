<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Session $model */

$this->title = 'Update Session: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sessions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="session-update container mt-5 mb-5">

<h4 class="alert alert-success"><?= Html::encode($this->title) ?> | Admin Dashboard</h4>

    <?= $this->render('_form', [
           'model' => $model,
            'allusers' => $allusers,
            'allquizz' => $allquizz,
            'usermodel' => $usermodel,
            'quizmodel' => $quizmodel,
            'videos' => $videos
    ]) ?>

</div>
