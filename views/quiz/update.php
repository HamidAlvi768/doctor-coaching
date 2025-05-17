<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Quiz $model */

$this->title = 'Update Quiz: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Quizzes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quiz-update container mt-5 mb-5">

    <h4 class="alert alert-success"><?= Html::encode($this->title) ?> | Admin panel</h4>


    <div class="containert mb-2" style="display: flex; justify-content: right;">
        <a href="<?php echo Url::to(["quiz/results?id=$model->id"])  ?>" class="btn btn-info">Results</a>
    </div>


    <?= $this->render('_form', [
        'model' => $model,
        'sessions' => $sessions,
        'question' => $question,
        'saved_questions' => $saved_questions,
        'answer' => $answer,
        'video' => $video,
        'size' => $size
    ]) ?>

</div>

<?php
