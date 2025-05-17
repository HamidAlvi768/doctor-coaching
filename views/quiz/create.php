<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Quiz $model */

$this->title = 'Create Quiz';
$this->params['breadcrumbs'][] = ['label' => 'Quizzes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quiz-create container mt-5 mb-5">

<div class="card card-primary">
        <div class="card-header">
            Quiz Form
        </div>
        <div class="card-body">
    <h4 class="alert alert-success"><?= Html::encode($this->title) ?></h4>
    
        <?= $this->render('_form', [
        'model' => $model,
        'sessions' => $sessions
    ]) ?>
        </div>
</div>
</div>
    

</div>
