<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Quiz $model */
/** @var yii\widgets\ActiveForm $form */
?>
<section class="container mt-5 mb-5">
    <div class="row">
        <div class="card card-success">
            <div class="card-header">
                <h4>Online Lectures </h4>
            </div>
            <div class="card-body">
                <div class="video-upload">
                    <?php $form = ActiveForm::begin([
                        'action' => ['session/lecture'], // Set the action to uploadvsideo
                        'options' => ['enctype' => 'multipart/form-data']
                    ]); ?>
                    <div class="">
                        <p><strong>Size:</strong> <span><?= $size ?> Gb/100 GB</span></p>
                    </div>
                    <div class="row">
                        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'required' => true]) ?>
                        <?= $form->field($model, 'description')->textarea(['maxlength' => true, 'required' => true]) ?>
                        <!-- <div class="col-md-3">
                        <?= $form->field($model, 'session_id')->dropDownList($sessions) // Assume you have sessions data available 
                        ?>
                    </div> -->
                        <div class="col-md-12">
                            <?= $form->field($model, 'quiz_id')->dropDownList(
                                \yii\helpers\ArrayHelper::map(
                                    \app\models\Quiz::find()->all(),
                                    'id',
                                    'title' // Assuming 'title' is the display field in your Quiz model
                                ),
                                ['prompt' => 'Select a Quiz', 'required' => true] // Added required attribute
                            ) ?>
                        </div>
                    </div>
                    <?php if (!isset($_REQUEST['id'])) {
                    ?>
                        <?= $form->field($model, 'file_path')->fileInput() ?>
                    <?php
                    } ?>

                    <?php if (isset($_REQUEST['id'])) {
                    ?>
                        <?= $form->field($model, 'id')->hiddenInput()->label('') ?>
                    <?php
                    } ?>



                    <div class="form-group" style="float:right;">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
                <?php if (isset($video->file_path) && $video->file_path != null) {
                    $v = $video; ?>
                    <section style="margin-top:100px; padding: 20px; border-top:2px solid black;">


                        <h6>Video Uploaded for this lecture</h6>
                        <div class="row">
                            <p style="color:black;">
                                <?= $v->title ?>
                                <span style="float:right;">

                                    <?php
                                    $encryptedId = Yii::$app->security->encryptByKey($v->id, 'rmabsalibaig');
                                    $encryptedId = base64_encode($encryptedId);
                                    ?>
                                    <a class="btn btn-success" href="<?= yii\helpers\Url::to(['session/stream', 'id' => $encryptedId]) ?>">Watch Video</a>

                                </span>
                            </p>
                        </div>



                    </section>
                <?php } ?>

            </div>
        </div>
    </div>
</section>