<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Events Detail';
$this->params['breadcrumbs'][] = $this->title;
?>

    <!-- bradcam_area_start  -->
    <div class="bradcam_area breadcam_bg">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text">
                        <h3>event details</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end  -->

    <div class="event_details_area section__padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="single_event d-flex align-items-center mb-4">
                        <div class="thumb">
                            <img src="<?= Yii::getAlias('@web/img/event/1.png') ?>" alt="Medical Ethics in Modern Practice">
                            <div class="date text-center">
                                <h4>15</h4>
                                <span>Oct, 2024</span>
                            </div>
                        </div>
                        <div class="event_details_info">
                            <div class="event_info">
                                <a href="#">
                                    <h4>Medical Ethics in Modern Practice</h4>
                                </a>
                                <p><span> <i class="flaticon-clock"></i> 11:00 am</span> <span> <i
                                            class="flaticon-calendar"></i> 15 Oct 2024</span> <span> <i
                                            class="flaticon-placeholder"></i> City Hospital Auditorium</span></p>
                            </div>
                            <p class="event_info_text">This event will focus on navigating the complex landscape of
                                medical ethics in contemporary practice. Our esteemed panelists will address critical
                                topics, including patient autonomy, informed consent, and the impact of technology on
                                ethical decision-making.</p>
                            <a href="#" class="boxed-btn3">Book a seat</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
