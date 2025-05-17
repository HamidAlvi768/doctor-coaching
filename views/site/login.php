<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .responsive-div-custom {
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }

    @media only screen and (max-width: 768px) {

        /* Tablet and smaller screens */
        .responsive-div-custom {
            width: 100%;
        }
    }
</style>
<section class="container mt-5 mb-5">
    <div class="card card-primary responsive-div-custom" style="">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>Please fill out the following fields to login:</p>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => ' col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('email/username') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"custom-control text-start custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ]) ?>

            <div class="form-group text-start" style="display: flex;justify-content:space-between;">
                <div>
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
                <div class="forget-link">
                    <a href="<?= Url::to(['site/forget-password']) ?>"><small>Forget Password?</small></a>
                </div>
            </div>
            <div class="" style="display: flex;justify-content:right;">
                <small>If you do not have an account? <a href="<?php echo Url::to(['site/signup']) ?>" class="btn-link">Signup</a></small>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
</section>