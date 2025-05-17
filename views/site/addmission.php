<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Addmission';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- latest_coures_area_start  -->
   <div class="admission_area">
        <div class="admission_inner">
            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-lg-7">
                        <div class="admission_form">
                            <h3>Apply for Admission</h3>
                            <form action="#">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="single_input">
                                            <input type="text" placeholder="First Name" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="single_input">
                                            <input type="text" placeholder="Last Name" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="single_input">
                                            <input type="text" placeholder="Phone Number" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="single_input">
                                            <input type="text" placeholder="Email Address" >
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single_input">
                                            <textarea cols="30" placeholder="Write an Application" rows="10"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="apply_btn">
                                            <button class="boxed-btn3" type="submit">Apply Now</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ latest_coures_area_end -->


    <!-- recent_event_area_strat  -->
    <div class="recent_event_area section__padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="section_title text-center mb-70">
                        <h3 class="mb-45">Recent Events</h3>
                        <p>Join our latest medical events to enhance your skills and knowledge with experts from the industry.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="single_event d-flex align-items-center">
                        <div class="date text-center">
                            <span>15</span>
                            <p>Oct, 2024</p>
                        </div>
                        <div class="event_info">
                            <a href="event_details1.html">
                                <h4>Medical Ethics in Modern Practice</h4>
                            </a>
                            <p><span> <i class="flaticon-clock"></i> 11:00 am</span> <span> <i class="flaticon-calendar"></i> 15 Oct 2024</span> <span> <i class="flaticon-placeholder"></i> City Hospital Auditorium</span></p>
                        </div>
                    </div>
                    <div class="single_event d-flex align-items-center">
                        <div class="date text-center">
                            <span>22</span>
                            <p>Oct, 2024</p>
                        </div>
                        <div class="event_info">
                            <a href="event_details2.html">
                                <h4>Advances in Medical Technology</h4>
                            </a>
                            <p><span> <i class="flaticon-clock"></i> 2:00 pm</span> <span> <i class="flaticon-calendar"></i> 22 Oct 2024</span> <span> <i class="flaticon-placeholder"></i> Grand Medical Conference Hall</span></p>
                        </div>
                    </div>
                    <div class="single_event d-flex align-items-center">
                        <div class="date text-center">
                            <span>30</span>
                            <p>Oct, 2024</p>
                        </div>
                        <div class="event_info">
                            <a href="event_details3.html">
                                <h4>Workshop on Surgical Techniques</h4>
                            </a>
                            <p><span> <i class="flaticon-clock"></i> 9:30 am</span> <span> <i class="flaticon-calendar"></i> 30 Oct 2024</span> <span> <i class="flaticon-placeholder"></i> National Medical Center</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- recent_event_area_end  -->
