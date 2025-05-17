<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    @media only screen and (max-width: 992px){
    .img-1{
        display: none;
    }
    .img-2{
        display: block;
    }
}
@media only screen and (min-width: 992px){
    .img-1{
        display: block;
    }
    .img-2{
        display: none;
    }
}
</style>
<!-- bradcam_area_start  -->
<div class="bradcam_area breadcam_bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="bradcam_text">
                    <h3>Our Courses</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- bradcam_area_end  -->
<!-- popular_program_area_start  -->
<div class="popular_program_area section__padding">
    <div class="container">
        <!-- <div class="row section__padding">
            <div class="col-lg-12">
                <div class="section_title text-center">
                    <h3>Popular Program</h3>
                </div>
            </div>
        </div> -->
        <section class="service-section">
            <div class="container">
                <div class="row col-12 m-auto">
                    <div class="col-lg-6 text-start py-5 align-content-center">
                        <h6 class="text-dark">"Pakistan Medical and Dental Council
                        "</h6>
                        <h1 class="text-dark">We offer
                            <span class="clr-gold">
                            PMDC NEB

                            </span>
                        </h1>
                        <p class="text-dark">
                            "The PMDC NEB exam enables international medical graduates to practice in Pakistan by testing their medical knowledge and clinical skills."
                        </p>
                        <a href="<?= \yii\helpers\Url::to(['/site/signup']) ?>" class="boxed-btn5">Apply Now</a>
                    </div>
                    <div class="col-lg-6 text-center align-content-center py-3">
                        <img src="<?= Yii::getAlias('@web/img/program/pmdc-neb.jpg') ?>"
                            alt="" style="width:100%;">
                    </div>
                </div>
            </div>
        </section>
                <section class="service-section">
            <div class="container">
                <div class="row col-12 m-auto">
                    <div class="col-lg-6 text-center align-content-center py-3 img-1">
                        <img src="<?= Yii::getAlias('@web/img/program/pmdc-neb.jpg') ?>"
                            alt="" style="width:90%;">
                    </div>
                    <div class="col-lg-6 text-start py-5 align-content-center">
                        <h6 class="text-dark">"Pakistan Medical and Dental Council
                        "</h6>
                        <h1 class="text-dark">We offer
                            <span class="clr-gold">
                            PMDC/NRE
                            </span>
                        </h1>
                        <p class="text-dark">
                            "Our PMDC/NRE Exam Preparation program provides proper guidance and resources, ensuring you're fully prepared for medical licensing success. ​​"
                        </p>
                        <a href="<?= \yii\helpers\Url::to(['/site/signup']) ?>" class="boxed-btn5">Apply Now</a>
                    </div>
                    <div class="col-lg-6 text-center align-content-center py-3  img-2">
                        <img src="<?= Yii::getAlias('@web/img/program/pmdc-neb.jpg') ?>"
                            alt="" style="width:90%;">
                    </div>
                </div>
            </div>
        </section>
        <section class="service-section">
            <div class="container">
                <div class="row col-12 m-auto">
                    <div class="col-lg-6 text-start py-5 align-content-center">
                        <h6 class="text-dark">"United States Medical Licensing Examination"</h6>
                        <h1 class="text-dark">We offer
                            <span class="clr-gold">
                            USMLE1
                            </span>
                        </h1>
                        <p class="text-dark">
                            "Prepare for the USMLE, a three-step exam required for medical licensure in the United
                            States, covering basic sciences, clinical knowledge, and clinical skills."
                        </p>
                        <a href="<?= \yii\helpers\Url::to(['/site/signup']) ?>" class="boxed-btn5">Apply Now</a>
                    </div>
                    <div class="col-lg-6 text-center align-content-center py-3">
                        <img src="<?= Yii::getAlias('@web/img/program/usmle.png') ?>"
                            alt="" style="width:100%;">
                    </div>
                </div>
            </div>
        </section>
        <section class="service-section">
            <div class="container">
                <div class="row col-12 m-auto">
                    <div class="col-lg-6 text-center align-content-center py-3 img-1">
                        <img src="<?= Yii::getAlias('@web/img/program/plab.png') ?>"
                            alt="" style="width:100%;">
                    </div>
                    <div class="col-lg-6 text-start py-5 align-content-center">
                        <h6 class="text-dark">"Professional Linguistic Assessments Board"</h6>
                        <h1 class="text-dark">We offer
                            <span class="clr-gold">
                            PLAB1
                            </span>
                        </h1>
                        <p class="text-dark">
                            "Designed for international medical graduates to practice in the UK, PLAB 
                            tests your ability to work as a doctor in UK healthcare settings."
                        </p>
                        <a href="<?= \yii\helpers\Url::to(['/site/signup']) ?>" class="boxed-btn5">Apply Now</a>
                    </div>
                    <div class="col-lg-6 text-center align-content-center py-3  img-2">
                        <img src="<?= Yii::getAlias('@web/img/program/plab.png') ?>"
                            alt="" style="width:100%;">
                    </div>
                </div>
            </div>
        </section>
        <section class="service-section">
            <div class="container">
                <div class="row col-12 m-auto">
                    <div class="col-lg-6 text-start py-5 align-content-center">
                        <h6 class="text-dark">"Fellowship of the CPS Pakistan
                        "</h6>
                        <h1 class="text-dark">We offer
                            <span class="clr-gold">
                            FCPS
                            </span>
                        </h1>
                        <p class="text-dark">
                            "Our FCPS program equips you with comprehensive clinical and theoretical training, guiding you toward advanced specialization in diverse medical fields."
                        </p>
                        <a href="<?= \yii\helpers\Url::to(['/site/signup']) ?>" class="boxed-btn5">Apply Now</a>
                    </div>
                    <div class="col-lg-6 text-center align-content-center py-3">
                        <img src="<?= Yii::getAlias('@web/img/program/fcps.jpg') ?>"
                            alt="" style="width:100%;">
                    </div>
                </div>
            </div>
        </section>
        <section class="service-section">
            <div class="container">
                <div class="row col-12 m-auto">
                    <div class="col-lg-6 text-center align-content-center py-3 img-1">
                        <img src="<?= Yii::getAlias('@web/img/program/aaa.webp') ?>"
                            alt="" style="width:100%;">
                    </div>
                    <div class="col-lg-6 text-start py-5 align-content-center">
                        <h6 class="text-dark">"Master in Medicine/Surgery
                        "</h6>
                        <h1 class="text-dark">We offer
                            <span class="clr-gold">
                            MD/MS
                            </span>
                        </h1>
                        <p class="text-dark">
                            "Our MD/MS program provides training withpractical experience andtheoretical knowledge to prepare you for leadership roles in medical specialties."
                        </p>
                        <a href="<?= \yii\helpers\Url::to(['/site/signup']) ?>" class="boxed-btn5">Apply Now</a>
                    </div>
                    <div class="col-lg-6 text-center align-content-center py-3  img-2">
                        <img src="<?= Yii::getAlias('@web/img/program/aaa.webp') ?>"
                            alt="" style="width:100%;">
                    </div>
                </div>
            </div>
        </section>
        
        <!-- <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="single__program">
                            <div class="program_thumb">
                                <img src="<?= Yii::getAlias('@web/img/program/usmle.png') ?>" alt="">
                            </div>
                            <div class="program__content">
                                <span>USMLE1</span>
                                <h4>United States Medical Licensing Examination</h4>
                                <p>Prepare for the USMLE, a three-step exam required for medical licensure in the United
                                    States, covering basic sciences, clinical knowledge, and clinical skills.</p>
                                <a href="Admissions.html" class="boxed-btn5">Apply Now</a>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="col-lg-4 col-md-6">
                        <div class="single__program">
                            <div class="program_thumb">
                                <img src="<?= Yii::getAlias('@web/img/program/moh-sle.jpg') ?>" alt="">
                            </div>
                            <div class="program__content">
                                <span>MOH/SLE</span>
                                <h4>Ministry of Health Saudi Licensing Exam</h4>
                                <p>Prepare for MOH and SLE, the medical exams required to practice in countries like Saudi Arabia and UAE, focusing on clinical knowledge and skills.</p>
                                <a href="Admissions.html" class="boxed-btn5">Apply Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single__program">
                            <div class="program_thumb">
                                <img src="<?= Yii::getAlias('@web/img/program/mbbs.jpeg') ?>" alt="">
                            </div>
                            <div class="program__content">
                                <span>MBBS</span>
                                <h4>Bachelor of Medicine, Bachelor of Surgery</h4>
                                <p>Our MBBS program equips future doctors with comprehensive medical knowledge, clinical skills, and preparing them for global medical practice.</p>
                                <a href="Admissions.html" class="boxed-btn5">Apply Now</a>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="col-lg-4 col-md-6">
                        <div class="single__program">
                            <div class="program_thumb">
                                <img src="<?= Yii::getAlias('@web/img/program/amc.png') ?>" alt="">
                            </div>
                            <div class="program__content">
                                <span>AMC Exam</span>
                                <h4>Australian Medical Council Exam</h4>
                                <p>Prepare for the AMC exam, which assesses your medical knowledge and skills for recognition to practice medicine in Australia.</p>
                                <a href="Admissions.html" class="boxed-btn5">Apply Now</a>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="col-lg-4 col-md-6">
                        <div class="single__program">
                            <div class="program_thumb">
                                <img src="<?= Yii::getAlias('@web/img/program/plab.png') ?>" alt="">
                            </div>
                            <div class="program__content">
                                <span>PLAB1</span>
                                <h4>Professional Linguistic Assessments Board</h4>
                                <p>Designed for international medical graduates to practice in the UK, PLAB tests your
                                    ability to work as a doctor in UK healthcare settings.</p>
                                <a href="Admissions.html" class="boxed-btn5">Apply Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single__program">
                            <div class="program_thumb">
                                <img src="<?= Yii::getAlias('@web/img/program/pmdc-neb.jpg') ?>" alt="">
                            </div>
                            <div class="program__content">
                                <span>PMDC NEB</span>
                                <h4>Pakistan Medical and Dental Council</h4>
                                <p>The PMDC NEB exam enables international medical graduates to practice in Pakistan by
                                    testing their medical knowledge and clinical skills.</p>
                                <a href="Admissions.html" class="boxed-btn5">Apply Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single__program">
                            <div class="program_thumb">
                                <img src="<?= Yii::getAlias('@web/img/program/fcps.jpg') ?>" alt="">
                            </div>
                            <div class="program__content">
                                <span>FCPS</span>
                                <h4>Fellowship of the CPS Pakistan</h4>
                                <p>Our FCPS program equips you with comprehensive clinical and theoretical training,
                                    guiding you toward advanced specialization in diverse medical fields.</p>
                                <a href="Admissions.html" class="boxed-btn5">Apply Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single__program">
                            <div class="program_thumb">
                                <img src="<?= Yii::getAlias('@web/img/program/aaa.webp') ?>" alt="">
                            </div>
                            <div class="program__content">
                                <span>MD/MS</span>
                                <h4>Master in Medicine/Surgery</h4>
                                <p>Our MD/MS program provides training withpractical experience andtheoretical knowledge
                                    to prepare you for leadership roles in medical specialties.</p>
                                <a href="Admissions.html" class="boxed-btn5">Apply Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single__program">
                            <div class="program_thumb">
                                <img src="<?= Yii::getAlias('@web/img/program/pmdc-neb.jpg') ?>" alt="">
                            </div>
                            <div class="program__content">
                                <span>PMDC/NRE</span>
                                <h4>Pakistan Medical and Dental Council</h4>
                                <p>Our PMDC/NRE Exam Preparation program provides proper guidance and resources,
                                    ensuring you're fully prepared for medical licensing success. ​​</p>
                                <a href="Admissions.html" class="boxed-btn5">Apply Now</a>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-lg-4 col-md-6">
                        <div class="single__program">
                            <div class="program_thumb">
                                <img src="<?= Yii::getAlias('@web/img/program/mrcp.png') ?>" alt="">
                            </div>
                            <div class="program__content">
                                <span>MRCP</span>
                                <h4>Membership of RC of Physicians</h4>
                                <p>Our MRCP course provides an in-depth understanding of medical practices, preparing you for the three-part exam required to practice medicine in the UK.</p>
                                <a href="Admissions.html" class="boxed-btn5">Apply Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single__program">
                            <div class="program_thumb">
                                <img src="<?= Yii::getAlias('@web/img/program/MRCOG.jpg') ?>" alt="">
                            </div>
                            <div class="program__content">
                                <span>MRCOG</span>
                                <h4>MRC of Obstetricians and Gynaecologists</h4>
                                <p>Our MRCOG preparation program provides in-depth training in obstetrics and gynaecology, preparing you to pass the exams required to practice in the UK.</p>
                                <a href="Admissions.html" class="boxed-btn5">Apply Now</a>
                            </div>
                        </div>
                    </div> -->
                <!-- </div>
            </div>
        </div> -->
    <!-- </div> --> 
</div>

<!-- popular_program_area_end -->