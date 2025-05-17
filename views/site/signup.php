<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Url;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h2 class="contact-title">Registration Form</h2>
                    <p>Please fill all fields and select available sessions</p>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'form-signup',
                        'options' => ['enctype' => 'multipart/form-data'],
                        'enableClientValidation' => true,
                    ]); ?>

                    <!-- Display validation errors -->
                    <?php if ($model->hasErrors()): ?>
                        <div class="alert alert-danger" style="color:red;">
                            <?= Html::errorSummary($model, ['encode' => false]) ?>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'full_name') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'father_name') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'cnic') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'gender')->dropDownList([
                                'male' => 'Male',
                                'female' => 'Female',
                                'other' => 'Other'
                            ], ['prompt' => 'Select Gender']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'number')->label('Contact Number') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'uni')->label('University') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'workplace') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'city') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'email') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'password')->passwordInput() ?>
                        </div>
                        <div class="col-md-12">
                            <?php //echo $form->field($model, 'cnicFile')->fileInput(['accept' => 'image/png,image/jpeg,image/jpg'])->label('CNIC Front Image') ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Select Sessions (Register for):</label>
                        <?= $form->field($model, 'register_for[]')->checkboxList(
                            \yii\helpers\ArrayHelper::map($sessions, 'id', 'name'),
                            ['unselect' => null]
                        )->label(false) ?>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'captcha')->widget(Captcha::className(), [
                                'captchaAction' => 'site/captcha',
                                'template' => '{image} {input}',
                            ]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'terms_accepted')->checkbox([
                            'label' => 'I agree to the ' . Html::a('Terms and Conditions', ['site/terms'], [
                                'target' => '_blank',
                                'rel' => 'noopener noreferrer',
                                'class' => 'terms-link'
                            ]),
                            'uncheck' => 0,
                        ]) ?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    </div>
                    <div class="" style="display: flex;justify-content:right;">
                        <small>If you have an account? <a href="<?php echo Url::to(['site/login']) ?>" class="btn-link">Login</a></small>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .form-group div {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .terms-link {
        color: #234262;
        text-decoration: none;
    }

    .terms-link:hover {
        color: #2a5298;
        text-decoration: underline;
    }

    .form-group.field-signupform-terms_accepted {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 15px;
    }

    .form-group.field-signupform-terms_accepted label {
        margin: 0;
        font-size: 0.95rem;
    }
</style>