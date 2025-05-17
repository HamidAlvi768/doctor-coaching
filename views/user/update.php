<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $sessions array */
/* @var $assignedSessions array */

$this->title = 'Update User: ' . $model->username;
$baseUrl = Yii::$app->request->baseUrl;
?>

<div class="user-update container mt-5">

    <h4 class="alert alert-success"><?= Html::encode($this->title) ?> | Admin Dashboard</h4>

    <div class="row">
        <div class="">
            <div class="card card-primary shadow-sm mb-4">
                <div class="card-header">
                    <h5>Update user detail</h5>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'full_name')->textInput(['class' => 'form-control', 'required' => true]) ?>
                        </div>
                        <div class="col-md-6"><?= $form->field($model, 'father_name')->textInput(['class' => 'form-control', 'required' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'cnic')->textInput(['class' => 'form-control', 'required' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'gender')->dropDownList([
                                'male' => 'Male',
                                'female' => 'Female',
                                'other' => 'Other'
                            ], ['prompt' => 'Select Gender', 'required' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'number')->textInput(['class' => 'form-control']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'city')->textInput(['class' => 'form-control']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'email')->textInput(['class' => 'form-control']) ?>
                        </div>
                        
                        <div class="col-md-6">
                            <!-- Password field -->
                            <?= $form->field($model, 'new_password')->passwordInput(['value' => ''])->label('New Password') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'uni')->textInput(['class' => 'form-control', 'required' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'workplace')->textInput(['class' => 'form-control', 'required' => true]) ?>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'fee_paid')->dropDownList([
                                'yes' => 'Yes',
                                'no' => 'No'
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'status')->dropDownList([
                                'active' => 'Active',
                                'inactive' => 'Inactive'
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'email_verified')->checkbox() ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Select Sessions:</label>
                            <?= Html::checkboxList('SignupForm[register_for]', explode(',', $model->register_for), \yii\helpers\ArrayHelper::map($sessions, 'id', 'name')) ?>
                        </div>

                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="card shadow-sm mt-2 mb-5">
                <div class="card-header">
                    <h5>Fee Slips</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- All Sessions -->
                        <?php foreach ($getImages as $image): ?>
                            <div class="col-md-4">
                                <img src="<?= $baseUrl . '/' . $image->file_path ?>" style="width: 100px; height: auto;">
                            </div>
                        <?php endforeach; ?>

                        <!-- Assigned Sessions -->
                        <!-- <div class="col-md-6">
                            <h6>Assigned Sessions</h6>
                            <div id="assigned-sessions">
                                <div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <!-- Sessions Assignment Section -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5>Assigned Sessions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- All Sessions -->
                        <div class="col-md-6">
                            <h6>Available Sessions</h6>
                            <div id="available-sessions">
                                <div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
                            </div>
                        </div>

                        <!-- Assigned Sessions -->
                        <div class="col-md-6">
                            <h6>Assigned Sessions</h6>
                            <div id="assigned-sessions">
                                <div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3 mb-3">
                <div class="card-header">
                    <h4>Attempted Quiz List</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach ($attempted_quiz as $q) {
                        ?>
                            <li class="list-group-item">
                                <?= $q->title ?>
                                <a href="<?= \yii\helpers\Url::to(['user/deletestudentresponse?qid=' . $q->id . '&sid=' . $_REQUEST['id']]) ?>" style="float:right;" class="btn btn-warning">Allow Re-Attempt</a>
                            </li>
                        <?php
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$assignUrl = \yii\helpers\Url::to(['user/assign-session']);
$removeUrl = \yii\helpers\Url::to(['user/remove-session']);
$loadSessionsUrl = \yii\helpers\Url::to(['user/load-sessions', 'userId' => $model->id]);

$js = <<<JS
// Load all sessions and assigned sessions on page load
function loadSessions() {
    $.get('$loadSessionsUrl&type=available', function(response) {
        if (response.success) {
           // console.log(response);
            let availableHtml = '<ul class="list-group">';
            response.sessions.forEach(session => {
                availableHtml += '<li class="list-group-item" data-id="' + session.id + '">' +
                    '' + session.name + '' +
                   
                    '<button class="btn btn-sm btn-primary float-end assign-session-btn">Assign</button>' +
                    '</li>';
            });
            $('#available-sessions').html(availableHtml+'</ul>');
        }
    });

    $.get('$loadSessionsUrl&type=assigned', function(response) {
        if (response.success) {
            let assignedHtml = '<ul class="list-group">';
            response.sessions.forEach(session => {
                assignedHtml += '<li class="list-group-item" data-id="' + session.id + '">' +
                    '' + session.name + '' +
                  
                    '<button class="btn btn-sm btn-danger float-end remove-session-btn">Remove</button>' +
                    '</li>';
            });
            $('#assigned-sessions').html(assignedHtml+'</ul>');
        }
    });
}

// Assign Session
$(document).on('click', '.assign-session-btn', function() {
    var sessionId = $(this).closest('li').data('id');
    
    $.post('$assignUrl', { session_id: sessionId, user_id: $model->id }, function(response) {
        if (response.success) {
            loadSessions(); // Reload sessions after successful assignment
        } else {
            alert(response.message || 'Error in saving data');
        }
    });
});

// Remove Session
$(document).on('click', '.remove-session-btn', function() {
    var sessionId = $(this).closest('li').data('id');
    
    $.post('$removeUrl', { session_id: sessionId, user_id: $model->id }, function(response) {
        if (response.success) {
            loadSessions(); // Reload sessions after successful removal
        } else {
            alert(response.message || 'Error in saving data');
        }
    });
});

// Initial load of sessions
loadSessions();
JS;

$this->registerJs($js);
?>