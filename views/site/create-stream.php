<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="container mt-5">
    <h4 class="alert alert-success">Create Stream</h4>

    <div class="row">
        <div class="stream-form">

            <?php $form = ActiveForm::begin([]); ?>

            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'stream_type')->dropDownList([
                        'youtube' => 'YouTube',
                        'zoom' => 'Zoom',
                    ], ['prompt' => 'Select Stream Type']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'meeting_id')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'meeting_passcode')->textInput() ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'stream_url')->textInput()->label('Url (use embed url for YoutTube videos or stream)') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'start_time')->input('datetime-local') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'end_time')->input('datetime-local') ?>
                </div>
            </div>
            <!-- <?= $form->field($model, 'active')->checkbox() ?> -->

            <div class="row mb-4">
                <div class="col-md-offset-3 col-md-6">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-secondary']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>