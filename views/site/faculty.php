<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Faculty';
$this->params['breadcrumbs'][] = $this->title;
?>

   
    <!-- bradcam_area_start  -->
    <div class="bradcam_area breadcam_bg">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text">
                        <h3>our faculty</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end  -->

    <div class="faculty_area section__padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="section_title text-center mb-70">
                        <h3 class="mb-4">Our Faculty</h3>
                        <p>Meet our experienced and dedicated faculty members who are committed to providing the best
                            education and guidance to our students.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Faculty Member 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="single_faculty_card position-relative">
                        <img src="<?= Yii::getAlias('@web/img/experts/1.png') ?>" alt="Faculty Member 1">
                        <div class="overlay">
                            <p class="px-3 text-white">Dedicated to nurturing the future of healthcare professionals.</p>
                        </div>
                        <div class="faculty_info text-center">
                            <h4>Dr. Sam Johnson</h4>
                            <p>Professor of Medicine</p>
                        </div>
                    </div>
                </div>
                <!-- Faculty Member 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="single_faculty_card position-relative">
                        <img src="<?= Yii::getAlias('@web/img/experts/2.png') ?>" alt="Faculty Member 2">
                        <div class="overlay">
                            <p class="px-3 text-white">Passionate about advancing surgical techniques and education.</p>
                        </div>
                        <div class="faculty_info text-center">
                            <h4>Dr. Mark Thompson</h4>
                            <p>Associate Professor of Surgery</p>
                        </div>
                    </div>
                </div>
                <!-- Faculty Member 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="single_faculty_card position-relative">
                        <img src="<?= Yii::getAlias('@web/img/experts/3.png') ?>" alt="Faculty Member 3">
                        <div class="overlay">
                            <p class="px-3 text-white">Committed to excellence in teaching and clinical practice.</p>
                        </div>
                        <div class="faculty_info text-center">
                            <h4>Dr. Davis Khan</h4>
                            <p>Lecturer in Anatomy</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


