<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>


<!-- ================ contact section start ================= -->
<section class="container mt-5 mb-5">

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h2 class="contact-title">Reset Password</h2>
                    <p>Send email to get new password.</p>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'email') ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Send Password', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

    </div>








</section>
<!-- ================ contact section end ================= -->