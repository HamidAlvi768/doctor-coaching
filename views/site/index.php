<?php

/** @var yii\web\View $this */
use yii\helpers\Html;

$this->title = 'Home';
?>
<style>
    @media (max-width: 767px) {
    .slider_area .single_slider .slider_text h3 {
        font-size: 20px !important;
    }
    .hideonmobile {
        display: none !important;
    }
}
</style>
<!-- HERO SECTION START (Bootstrap Carousel) -->
<div class="slider_area" data-aos="fade-up">
  <div id="heroCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#heroCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#heroCarousel" data-slide-to="1"></li>
      <li data-target="#heroCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="single_slider d-flex align-items-center slider_bg_1" style="width:100%;">
          <div class="container">
            <div class="row">
              <div class="col-xl-12">
                <div class="slider_text text-left">
                  <h3>We believe in<br>Quality education</h3>
                  <p class="text-dark hideonmobile">Let us help you in your medical exam</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="single_slider d-flex align-items-center slider_bg_2" style="width:100%;">
          <div class="container">
            <div class="row">
              <div class="col-xl-12">
                <div class="slider_text text-left">
                  <h3>Become the doctor,<br>the world needs.</h3>
                  <a href="#" class="btn btn-primary mx-2">Get Start</a>
                  <a href="#" class="btn btn-info mx-2">Take a tour</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="single_slider d-flex align-items-center slider_bg_3" style="width:100%;">
          <div class="container">
            <div class="row">
              <div class="col-xl-12">
                <div class="slider_text text-left">
                  <h3>Boost up your skills <br>with a new way of <br>learning.</h3>
                  <a href="#" class="btn btn-primary mx-2">Get Start</a>
                  <a href="#" class="btn btn-info mx-2">Take a tour</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
<!-- HERO SECTION END -->

    <!-- service_area_start  -->
    <div class="service_area gray_bg" data-aos="fade-up">
        <div class="container">
            <div class="row justify-content-center ">
                
                <div class="col-lg-3">
                    <div class="single_service service-card-1 d-flex flex-column align-items-center justify-content-between" data-aos="fade-up">
                        <div class="icon mb-3">
                            <img src="<?= Yii::getAlias('@web/img/program/pmdcpng.png') ?>"
                            alt="" style="width:104%; margin-top:-2px;">
                        </div>
                        <div class="service_info text-center mb-3">
                            <h4>NRE 1</h4>
                        </div>
                        <div>
                            <a href="<?= \yii\helpers\Url::to(['/site/onlinelectures?type=NRE 1']) ?>">view more</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="single_service service-card-2 d-flex flex-column align-items-center justify-content-between" data-aos="fade-up" data-aos-delay="100">
                        <div class="icon mb-3">
                            <img src="<?= Yii::getAlias('@web/img/program/pmdcpng.png') ?>"
                            alt="" style="width:104%; margin-top:-2px;">
                        </div>
                        <div class="service_info text-center mb-3">
                            <h4>NRE 2</h4>
                        </div>
                        <div>
                            <a href="<?= \yii\helpers\Url::to(['/site/onlinelectures?type=NRE 2']) ?>">view more</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="single_service service-card-3 d-flex flex-column align-items-center justify-content-between" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon mb-3">
                            <img src="<?= Yii::getAlias('@web/img/program/pmdcpng.png') ?>"
                            alt="" style="width:104%; margin-top:-2px;">
                        </div>
                        <div class="service_info text-center mb-3">
                            <h4>Online Exam</h4>
                        </div>
                        <div>
                            <a href="<?= \yii\helpers\Url::to(['/site/onlinequizzes']) ?>">view more</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="single_service service-card-4 d-flex flex-column align-items-center justify-content-between" data-aos="fade-up" data-aos-delay="300">
                        <div class="icon mb-3">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="service_info text-center mb-3">
                            <h4>Explanation Videos</h4>
                        </div>
                        <div>
                            <a href="<?= \yii\helpers\Url::to(['/site/onlinelectures?type=EV']) ?>">view more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ service_area_start  -->

    <!-- popular_program_area_start  -->
    <div class="popular_program_area section__padding" id="popular_program" data-aos="fade-up">
        <div class="container">
            <div class="row section__padding">
                <div class="col-lg-12 mb-5">
                    <div class="section_title text-center">
                        <h3>Popular Program</h3>
                    </div>
                </div>
                <div class="col-lg-12">
                    <p class="text-dark" style="position: relative; z-index: 111;">
                  
At Doctors Coaching Academy Islamabad, we provide comprehensive programs for medical graduates, available both online and offline. Our expert instructors and innovative teaching methods prepare students for essential post-MBBS licensure exams and certifications, including PMDC NRE, USMLE Step 1, and FCPS, among others. Whether you're aiming for qualifications in Pakistan or abroad, we ensure that quality education is accessible to help you succeed in your medical career!
                    </p>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-lg-12">
                    <nav class="custom_tabs text-center">
                        <div class="nav" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Graduate                                </a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Postgraduate </a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">PHD Scholarships</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact2" role="tab" aria-controls="nav-contact" aria-selected="false">Training</a>
                        </div>
                    </nav>
                </div>
            </div> -->
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="single__program mb-0">
                                <div class="program__content">
                                    <span>We Offer</span>
                                    <h4>Online Programs</h4>
                                    <p>Our online programs offer flexible learning for aspiring medical professionals. With interactive lectures and comprehensive resources, you can study at your own pace and receive personalized support from expert instructors, all from the comfort of your home.</p>
                                    <a href="<?= \yii\helpers\Url::to(['/site/signup']) ?>" class="boxed-btn5">Apply Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="single__program mb-0">
                                <div class="program__content">
                                    <span>We Offer</span>
                                    <h4>Onsite Programs</h4>
                                    <p>Our offline programs provide an immersive learning experience at our academy. Engage directly with experienced instructors and collaborate with peers in a dynamic classroom setting, equipping you with essential skills and knowledge for your medical career.</p>
                                    <a href="<?= \yii\helpers\Url::to(['/site/signup']) ?>" class="boxed-btn5">Apply Now</a>
                                </div>
                            </div>
                        </div
                    </div>
                </div>
            </div>
            

            <div class="row section__padding">
                <!-- <div class="col-lg-12">
                    <div class="course_all_btn text-center">
                        <a href="#" class="boxed-btn4">View All course</a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <!-- popular_program_area_end -->

    <!-- latest_coures_area_start  -->
    <div class="latest_coures_area" data-aos="fade-up">
        <div class="latest_coures_inner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="coures_info">
                            <div class="section_title white_text">
                                <h3>Latest Courses</h3>
                                <p>Doctors Coaching Academy offers up-to-date courses tailored to help medical professionals excel in their careers. Whether preparing for international exams or enhancing clinical skills, our programs provide comprehensive training to meet your goals. Explore the latest courses below and take the next step in your medical journey.</p>
                            </div>
                            <div class="coures_wrap d-flex gap-3">
                                <div class="single_wrap">
                                    <div class="icon">
                                        <img src="<?= Yii::getAlias('@web/img/program/pmdcpng.png') ?>" alt="PMDC NEB" style="width: 70px; height: 70px; object-fit: contain;">
                                    </div>
                                    <h4>PMDC NRE Exam</h4>
                                    <p>The PMDC NRE exam tests medical knowledge &nbsp;&nbsp;&nbsp;</p>
                                    <a href="<?= \yii\helpers\Url::to(['/site/signup']) ?>" class="boxed-btn5">Apply Now</a>
                                </div>
                                <div class="single_wrap">
                                    <div class="icon">
                                        <i class="flaticon-lab"></i> <!-- Replaced with an icon representing hospitals/medical institutions -->
                                    </div>
                                    <h4>Other Programs</h4>
                                    <p>FCPS, MD/MS, PLAB1, USMLE1</p>
                                    <a href="<?= \yii\helpers\Url::to(['/site/signup']) ?>" class="boxed-btn5">Apply Now</a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ latest_coures_area_end -->

    <!-- recent_event_area_strat  -->
    <div class="recent_event_area section__padding" data-aos="fade-up">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="section_title text-center mb-70">
                        <h3 class="mb-45">Current Sessions</h3>
                        <p>Join our latest medical sessions to enhance your skills and knowledge with experts from the industry.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">

                <?php foreach ($sessions as $session): ?>
                     <div class="single_event d-flex align-items-center">
                         <div class="date text-center">
                             <span><?= date('d', strtotime($session->start_time)) ?></span>
                             <p><?= date('M, Y', strtotime($session->start_time)) ?></p> 
                         </div>
                         <div class="event_info">
                             <!-- <a href="<?= \yii\helpers\Url::to(['session/view', 'id' => $session->id]) ?>"> -->
                                 <h4><?= Html::encode($session->name) ?></h4> 
                            <!-- </a> -->
                             <p><span><i class="flaticon-placeholder"></i> Islamabad / Online</span></p> 
                         </div>
                     </div>
                <?php endforeach; ?>

                    <!-- <div class="single_event d-flex align-items-center">
                        <div class="date text-center">
                            <span>22</span>
                            <p>Oct, 2024</p>
                        </div>
                        <div class="event_info">
                            <a href="#">
                                <h4>Advances in Medical Technology</h4>
                            </a>
                            <p><span> <i class="flaticon-placeholder"></i> Grand Medical Conference Hall</span></p>
                        </div>
                    </div>
                    <div class="single_event d-flex align-items-center">
                        <div class="date text-center">
                            <span>30</span>
                            <p>Oct, 2024</p>
                        </div>
                        <div class="event_info">
                            <a href="#">
                                <h4>Workshop on Surgical Techniques</h4>
                            </a>
                            <p><span> <i class="flaticon-placeholder"></i> National Medical Center</span></p>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    
    <!-- recent_event_area_end  -->




