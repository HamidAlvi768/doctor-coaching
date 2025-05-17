<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'OTP Verification';
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
    .btn-primary {
        background-color: #234262;
    }

    .btn-primary:hover {
        background-color: white;
        color: #234262;
    }
</style>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title text-center"><?= Html::encode($this->title) ?></h4>
                    <p class="text-center">Please verify your email to continue. We've sent a verification code to:</p>

                    <div class="text-center mb-4">
                        <strong><?= Yii::$app->user->identity->email; ?></strong>
                    </div>

                    <?php $form = \yii\widgets\ActiveForm::begin([
                        'id' => 'otpForm',
                        'options' => ['class' => 'form-horizontal'],
                    ]); ?>

                    <div class="otp-input-container mb-4" style="display: flex; justify-content: center; gap: 10px;">
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <input type="text"
                                class="otp-input form-control"
                                maxlength="1"
                                style="padding:0.5rem;text-align: center; border-radius: 8px; border: 1px solid #ccc;"
                                name="otp[]"
                                data-index="<?= $i ?>"
                                autocomplete="off">
                        <?php endfor; ?>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Verify OTP</button>
                    </div>

                    <?php \yii\widgets\ActiveForm::end(); ?>

                    <div class="text-center mt-3">
                        <a href="#" id="resend-otp" resend-link="<?php echo Yii::$app->urlManager->createUrl(['site/verify-otp?otp=new']) ?>" class="btn btn-link" id="resendCode">
                            <i class="fa fa-refresh"></i> Resend Code
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .page-overlay{
        width: 100%;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 999;
        display: flex;
        justify-content: center;
        align-items: center;
        display: none;
        background-color: #00000099;
    }
    .page-overlay p{
        background-color: #fafafa;
        color: #234262;
        padding: 10px;
        border-radius: 5px;
    }
</style>
<div class="page-overlay">
    <p>OTP Sending</p>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.otp-input');

        inputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value.length >= 1) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                }
            });

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        function otpResend() {
            const otpBtn = document.querySelector("#resend-otp");

            // Store the original link and text
            const originalLink = otpBtn.getAttribute("resend-link");
            const originalText = otpBtn.innerHTML;

            // Handle the click event
            otpBtn.addEventListener("click", () => {
                if (otpBtn.href !== "#" && otpBtn.href !== "") {
                    document.querySelector(".page-overlay").style.display="flex";
                }
            });

            // Start the countdown immediately after click
            let time = 5; // Countdown from 10 seconds
            otpBtn.innerHTML = `Resend in ${time}`; // Show initial countdown

            const interval = setInterval(() => {
                time--;
                otpBtn.innerHTML = `Resend in ${time}`; // Update countdown

                if (time === 0) {
                    otpBtn.innerHTML = originalText; // Restore original text
                    otpBtn.href = originalLink; // Restore original link
                    clearInterval(interval); // Stop the interval
                }
            }, 1000);
        }

        // Call the function to initialize
        otpResend();
    });
</script>

<style>
    .otp-input-container {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
    }

    .btn-link {
        font-size: 14px;
    }
</style>