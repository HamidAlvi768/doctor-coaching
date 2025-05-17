<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Quiz $model */
/** @var \Illuminate\Support\Collection $questions */
/** @var \Illuminate\Support\Collection $studentResponses */

$this->title = 'Attempt Quiz: ' . Html::encode($model->title);
$this->params['breadcrumbs'][] = ['label' => 'Quizzes Attempt', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Attempt';
?>
<div class="quiz-attempt">

    <h1><?= Html::encode($this->title) ?></h1>

    <form id="quiz-form">
        <?= Yii::$app->request->csrfParam ?>: <?= Yii::$app->request->csrfToken ?>

        <?php foreach ($questions as $question): ?>
        <div class="question">
            <h3><?= Html::encode($question->question_text) ?></h3>

            <?php 
            if ($question->type == 'mcq'){
            foreach ($question->answers as $option): ?>
            <div class="option">
                <label>
                    <input type="radio" name="answers[<?= $question->id ?>]" value="<?= $option->id ?>"
                        <?= isset($studentResponses[$question->id]) && $studentResponses[$question->id]->answer_id == $option->id ? 'checked' : '' ?>>
                    <?= Html::encode($option->answer_text) ?>
                </label>
            </div>
            <?php endforeach; 
            } elseif ($question->type == 'truefalse'){ ?>
            <div class="option">
                <label>
                    <input type="radio" name="answers[<?= $question->id ?>]" value="true"
                        <?= isset($studentResponses[$question->id]) && $studentResponses[$question->id]->student_answer == $option->id ? 'checked' : '' ?>>
                    True
                </label>
                <label>
                    <input type="radio" name="answers[<?= $question->id ?>]" value="false"
                        <?= isset($studentResponses[$question->id]) && $studentResponses[$question->id]->student_answer == $option->id ? 'checked' : '' ?>>
                    False
                </label>
            </div>


            <?php  } elseif ($question->type == 'text'){ ?>
            <div class="option">
                <label>
                    <input type="text" name="answers[<?= $question->id ?>]"
                        value="<?= isset($studentResponses[$question->id]) ? Html::encode($studentResponses[$question->id]->student_answer) : '' ?>"
                        class="form-control">
                </label>
            </div>
            <?php }
            ?>
        </div>
        <?php endforeach; ?>

        <div class="form-group">
            <?= Html::button('Submit Answers', ['class' => 'btn btn-success', 'id' => 'submit-button']) ?>
        </div>
    </form>

</div>

<?php
$js = <<<JS
$('#submit-button').on('click', function() {
    var answers = $('#quiz-form').serialize();
    $.ajax({
        url: 'submit-attempt?id={$model->id}',
        type: 'POST',
        data: answers,
        success: function(response) {
            if (response.status === 'success') {
                // Load next question or redirect as needed
                location.reload(); // or implement logic to show the next question
            } else {
                alert('Time is finished. You cannot submit answers now.');
            }
        },
        error: function() {
            alert('An error occurred while submitting your answers.');
        }
    });
});
JS;

$this->registerJs($js);
?>