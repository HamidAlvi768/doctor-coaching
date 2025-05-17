<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Session $model */

$this->title = 'Create Session';
$this->params['breadcrumbs'][] = ['label' => 'Sessions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="session-create container mt-5 mb-5">

   
    <h4 class="alert alert-success"><?= Html::encode($this->title) ?> | Admin Dashboard</h4>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
