<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- bradcam_area_start  -->
<div class="bradcam_area breadcam_bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="bradcam_text">
                    <h3>Contact</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- bradcam_area_end  -->

<!-- ================ contact section start ================= -->
<section class="contact-section">
    <div class="container">
        <!-- <div class="d-none d-sm-block mb-5 pb-4">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3518.256614207313!2d73.05519871502812!3d33.68326638070669!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38df8f2484c5f83d%3A0xe1f2f55c6b39a1f9!2sMain%20Road%2C%20above%20Sarhad%20Cash%20And%20Carry%20Building%20Explorer%20College%2C%20near%20Main%20Civic%20Center%2C%20Block%20A%20Jinnah%20Garden%2C%20Islamabad%2C%20Islamabad%20Capital%20Territory%2044010!5e0!3m2!1sen!2sus!4v1600000000000!5m2!1sen!2sus"
                        width="100%"
                        height="480"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"></iframe>
                </div>
                 -->


        <div class="row">
            <div class="col-12">
                <h2 class="contact-title">Get in Touch</h2>
            </div>
            <div class="col-lg-8">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3322.667300215211!2d73.13020517452844!3d33.61393584074911!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38df95010387d995%3A0xcde4d82b8a6c7f70!2sJantrah%20Tech%20(Pvt)%20Ltd.!5e0!3m2!1sen!2s!4v1745990191659!5m2!1sen!2s"
                    width="100%"
                    height="260"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"></iframe>
            </div>
            <div class="col-lg-3 offset-lg-1">
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-home"></i></span>
                    <div class="media-body">
                        <h3>Jantrah Tech (Pvt) LTD First Floor, Hamdan Heights, Express Way,</h3>
                        <p>Islamabad, </p>
                    </div>
                </div>
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                    <div class="media-body">
                        <h3>+92311 5254 544</h3>
                        <p>Mon to Fri 9am to 6pm</p>
                    </div>
                </div>
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-email"></i></span>
                    <div class="media-body">
                        <h3>info@jantrahtech.com</h3>
                        <!-- <h3>drcoachingacademy@gmail.com</h3> -->
                        <p>Send us your query anytime!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================ contact section end ================= -->