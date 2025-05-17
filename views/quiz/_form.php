<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Quiz $model */
/** @var yii\widgets\ActiveForm $form */
?>



<div class="quiz-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'session_id')->dropDownList($sessions) // Assume you have sessions data available 
            ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'start_at')->input('datetime-local') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'end_at')->input('datetime-local') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'duration_in_minutes')->input('number') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'status')->dropDownList(
                ['active' => 'active', 'not active' => 'not active', 'canceled' => 'canceled'], // Value => Label pairs

            ) ?>

        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php


    ActiveForm::end();
    $qid = $model->id;

    if (isset($question)) {
        $model = $question;
    ?>

        <section>

            <!-- Form to add questions -->
            <div class="card">
                <div class="card-header">
                    <h4>Add Question</h4>
                </div>
                <div class="card-body">
                    <?php Pjax::begin(['id' => 'question-form']); ?>

                    <?php $form = ActiveForm::begin([
                        'options' => ['data-pjax' => true],
                        'action' => ['question/create'],
                        'method' => 'post',
                        'id' => 'question-form-ajax',
                    ]); ?>

                    <?= $form->field($model, 'quiz_id')->hiddenInput(['value' => $qid])->label(false) ?>
                    <?= $form->field($model, 'question_text')->textarea(['placeholder' => 'Enter your question']) ?>
                    <?= $form->field($model, 'type')->dropDownList([
                        'mcq' => 'Multiple Choice',
                        'truefalse' => 'True/False',
                        'text' => 'Text Answer'
                    ], ['prompt' => 'Select Question Type', 'id' => 'question-type']) ?>

                    <!-- Dynamic Fields for MCQ -->
                    <div id="mcq-options" style="display:none;">
                        <label>Options</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="answers[]" placeholder="Option 1">
                            <input type="text" class="form-control" name="answers[]" placeholder="Option 2">
                            <input type="text" class="form-control" name="answers[]" placeholder="Option 3">
                            <input type="text" class="form-control" name="answers[]" placeholder="Option 4">
                        </div>
                        <?= Html::dropDownList('correct_answer', null, ['0' => 'Option 1', '1' => 'Option 2', '2' => 'Option 3', '3' => 'Option 4'], ['class' => 'form-control','id'=>'select-q-ans', 'prompt' => 'Select Correct Answer']) ?>
                    </div>

                    <!-- Dynamic Field for True/False -->
                    <div id="truefalse-options" style="display:none;">
                        <?= Html::dropDownList('truefalse_answer', null, ['True' => 'True', 'False' => 'False'], ['class' => 'form-control']) ?>
                    </div>

                    <!-- Dynamic Field for Text Answer -->
                    <div id="text-answer" style="display:none;">
                        <input type="text" class="form-control" name="text_answer" placeholder="Correct Text Answer">
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Add Question', ['class' => 'btn btn-success','id'=>'q-submit-btn']) ?>
                    </div>
                    <div id="form-result"></div> <!-- Message display -->
                    <?php ActiveForm::end(); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>

        </section>

        <section>


            <!-- Card to display the list of questions -->
            <div class="card mt-4">
                <div class="card-header">
                    <h4>List of Questions</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Question Text</th>
                                <th>Type</th>
                                <th>Options/Answers</th>
                            </tr>
                        </thead>
                        <tbody id="quesiton_list_table">
                            <?php $questions = $saved_questions;
                            if ($questions) {
                                $sr = 0;
                                foreach ($questions as $index => $question):
                                    $sr++;
                                    if ($question) {
                            ?>
                                        <tr>
                                            <td><?= $sr ?></td>
                                            <td><?= $question->question_text ?></td>
                                            <td><?= $question->type ?></td>
                                            <td>
                                                <?php if ($question->type == 'mcq'): ?>
                                                    <?php foreach ($question->answers as $answer): ?>
                                                        <p><?= $answer->answer_text ?> <?= $answer->is_correct ? '(Correct)' : '' ?></p>
                                                    <?php endforeach; ?>
                                                <?php elseif ($question->type == 'truefalse'): ?>
                                                    <p><?= $question->answers[0]->answer_text ?></p>
                                                <?php elseif ($question->type == 'text'): ?>
                                                    <p><?= $question->answers[0]->answer_text ?></p>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <form method="get" action="<?= \yii\helpers\Url::to(['question/delete']) ?>">
                                                    <input type="hidden" name="id" value="<?= $question->id ?>">
                                                    <input type="hidden" name="quiz_id" value="<?= $qid ?>">
                                                    <!-- Assuming $qid is available -->
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this question?');">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                            <?php }
                                endforeach;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <?php if (isset($_REQUEST['id'])) {
            $model = new \app\models\Video();
        ?>
            <section class="mt-3 mb-5">
                <div class="card card-success">
                    <div class="card-header">
                        <h4>Related Video</h4>
                    </div>
                    <div class="card-body">
                        <div class="video-upload">
                            <?php $form = ActiveForm::begin([
                                'action' => ['quiz/uploadvideo'], // Set the action to uploadvideo
                                'options' => ['enctype' => 'multipart/form-data']
                            ]); ?>
                            <div class="">
                                <p><strong>Size:</strong> <span><?= $size ?> Gb/100 GB</span></p>
                            </div>
                            <?php if (isset($_REQUEST['id'])) {
                            ?>
                                <?= $form->field($model, 'id')->textInput(['maxlength' => true, 'value' => Yii::$app->request->get('id')]) ?>
                            <?php
                            } ?>
                            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'file_path')->fileInput() ?>
                            <?= $form->field($model, 'quiz_id')->hiddenInput(['value' => Yii::$app->request->get('id')])->label(false) ?>

                            <div class="form-group" style="float:right;">
                                <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>

                        <?php if (isset($video) && $video != null) { ?>
                            <section style="margin-top:100px; padding: 20px; border-top:2px solid black;">
                                <?php
                                foreach ($video as $v) {
                                ?>
                                    <div class="row">
                                        <p style="color:black;">
                                            <?= $v->title ?>
                                            <span style="float:right;">
                                                <?= Html::a('Delete', ['quiz/deletevideo', 'id' => $v->id], [
                                                    'class' => 'btn btn-danger',
                                                    'data' => [
                                                        'confirm' => 'Are you sure you want to delete this quiz?',
                                                        'method' => 'post', // Use POST for the delete request to prevent CSRF attacks
                                                    ],
                                                ]) ?>
                                                <?php
                                                $encryptedId = Yii::$app->security->encryptByKey($v->id, 'rmabsalibaig');
                                                $encryptedId = base64_encode($encryptedId);
                                                ?>
                                                <a class="btn btn-success" href="<?= yii\helpers\Url::to(['quiz/stream', 'id' => $encryptedId]) ?>">Watch Video</a>

                                            </span>
                                        </p>
                                    </div>


                                <?php

                                }
                                ?>
                            </section>
                        <?php } ?>
                    </div>
                </div>
            </section>

        <?php
        } ?>

</div>

<!-- JS to show/hide fields dynamically -->
<?php
    }
    $script = <<< JS



// Handling the form submission via AJAX
$('#question-form-ajax').on('beforeSubmit', function(event) {
    event.preventDefault();
    let form = $(this);
    $('#q-submit-btn').text('Adding...').attr('disabled', true); // Disable the button to prevent multiple submissions
    
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function(response) {
            if(response.status === 'success') {
                $('#form-result').html('<div class="alert alert-success">' + response.message + '</div>');
                form[0].reset();  // Reset the form on success
                // Create a new row for the question table
                let newRow = '<tr>' +
    '<td>' + ($('#quesiton_list_table tr').length + 1) + '</td>' + // Increment the index
    '<td>' + response.question_text + '</td>' +
    '<td>' + response.type + '</td>' +
    '<td>' + (response.type === 'mcq' ? response.answers.map(answer => '<p>' + answer.answer_text + (answer.is_correct ? ' (Correct)' : '') + '</p>').join('') : response.answers[0].answer_text) + '</td>' +
    '<td>' +
        '<form method="get" action="../question/delete">' +
            '<input type="hidden" name="id" value="' + response.id + '">' +
            '<input type="hidden" name="quiz_id" value=" $qid ">' +
            '<button type="submit" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this question?\');">Delete</button>' +
        '</form>' +
    '</td>' +
'</tr>';


                // Prepend the new row to the table
                $('#quesiton_list_table').prepend(newRow);
                $('#q-submit-btn').text('Add Question').attr('disabled', false);
               
            } else {
                $('#form-result').html('<div class="alert alert-danger">' + response.message + '</div>');
                $('#q-submit-btn').text('Add Question').attr('disabled', false);
            }
        },
        error: function() {
            $('#q-submit-btn').text('Add Question').attr('disabled', false);
            $('#form-result').html('<div class="alert alert-danger">An error occurred while submitting the form.</div>');
        }
    });

    return false; // Prevent normal form submission
});

// Show/hide fields based on selected question type
$('#question-type').on('change', function() {
    var type = $(this).val();
    $('#mcq-options').hide();
    $('#truefalse-options').hide();
    $('#text-answer').hide();
    $('#select-q-ans').attr('required', false);
    
    if (type === 'mcq') {
        $('#mcq-options').show();
        $('#select-q-ans').attr('required', true);
    } else if (type === 'truefalse') {
        $('#truefalse-options').show();
    } else if (type === 'text') {
        $('#text-answer').show();
    }
});

JS;
    $this->registerJs($script);
?>