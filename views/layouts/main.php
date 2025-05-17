<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Html;

use app\models\News;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/img/logo.png')]);

?>

<?php $this->beginPage() ?>
<!doctype html>
<html lang="<?= Yii::$app->language ?>" class="no-js">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>PrimeMed Coaching | <?= Html::encode($this->title) ?></title>
    <link rel="icon" href="<?= Yii::getAlias('@web/img/logo.png') ?>" type="image/png">
    <?php $this->head() ?>
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/owl.carousel.min.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/owl.theme.default.min.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/magnific-popup.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/themify-icons.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/nice-select.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/flaticon.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/gijgo.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/animate.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/slicknav.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/style.css') ?>">
    <style>
        .faculty_area {
            background-color: #f9f9f9;
        }

        .single_faculty_card {
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .single_faculty_card img {
            width: 100%;
            height: auto;
            transition: transform 0.3s ease;
        }

        .single_faculty_card:hover img {
            transform: scale(1.1);
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .single_faculty_card:hover .overlay {
            opacity: 1;
        }

        .single_faculty_card:hover h4,
        .single_faculty_card:hover h6 {
            color: #fff !important;
        }

        .faculty_info {
            position: relative;
            z-index: 1;
            padding: 15px 0;
        }

        .showonmobile {
            display: none !important;
        }

        /* Show on mobile below 991px */
        @media (max-width: 991px) {
            .showonmobile {
                display: block !important;
            }
        }

        /* News Ticker Container */
        .news-ticker {
            background-color: #234262;
            /* Consistent with your theme */
            padding: 10px;
            font-size: 16px;
            color: #fefefe;
            /* White text for contrast */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            white-space: nowrap;
            max-width: 100%;
            /* Ensure it fits container */
            mask-image: linear-gradient(to right,
                    transparent 0%,
                    black 10%,
                    black 90%,
                    transparent 100%);
            /* Fade effect on edges */
            -webkit-mask-image: linear-gradient(to right,
                    transparent 0%,
                    black 10%,
                    black 90%,
                    transparent 100%);
            /* For cross-browser support */
        }

        /* Ticker Content */
        .ticker-content {
            display: inline-block;
            padding-left: 100%;
            /* Start off-screen */
            animation: ticker-scroll linear infinite;
            /* Base animation */
            will-change: transform;
            /* Optimize performance */
            color: #fefefe;
            /* Ensure text is white */
        }

        /* Duplicate content for seamless looping */
        .ticker-content::after {
            content: attr(data-content);
            padding-left: 50px;
            /* Reduced gap for smoother continuity */
        }

        /* Animation Keyframes */
        @keyframes ticker-scroll {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-100%);
            }
        }

        /* Pause on hover with smooth transition */
        .news-ticker:hover .ticker-content {
            animation-play-state: paused;
            transition: animation-play-state 0.2s ease;
            /* Smooth pause */
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .news-ticker {
                font-size: 14px;
                /* Slightly smaller on tablets */
                padding: 8px;
            }
        }

        @media (max-width: 576px) {
            .news-ticker {
                font-size: 12px;
                /* Smaller on mobile */
                padding: 6px;
            }
        }
        .help-block{
            color: red;
            font-size: 0.8rem;
        }
    </style>
</head>

<body>
    <?php $this->beginBody() ?>

    <!-- Header Start -->
    <header>
        <link rel="icon" href="<?= Yii::getAlias('@web/img/logo.png') ?>" type="image/png">
        <div class="header-area">
            <div id="sticky-header" class="main-header-area">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <div class="header_wrap d-flex justify-content-between align-items-center">
                                <div class="header_left">
                                    <div class="logo">
                                        <a class="d-flex align-items-center" href="<?= Yii::$app->homeUrl ?>">
                                            <img src="<?= Yii::getAlias('@web/img/logo.png') ?>" alt="" style="height: 45px;width: 50px;">
                                            <h5 class="m-0">PrimeMed Coaching</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="header_right d-flex align-items-center">
                                    <div class="main-menu d-none d-lg-block">
                                        <nav>
                                            <ul id="navigation">
                                                <li><a href="<?= Yii::$app->homeUrl ?>">Home</a></li>
                                                <li><a href="<?= \yii\helpers\Url::to(['/site/courses']) ?>">Courses</a></li>
                                                <li><a href="<?= \yii\helpers\Url::to(['/site/onlinelectures']) ?>">Lectures</a></li>
                                                <li><a href="<?= \yii\helpers\Url::to(['/site/onlinequizzes']) ?>">Quizzes</a></li>
                                                <li><a href="<?= \yii\helpers\Url::to(['/site/contact']) ?>">Contact</a></li>
                                                <?php if (Yii::$app->user->isGuest) { ?>
                                                    <li class="showonmobile"><a href="<?= \yii\helpers\Url::to(['/site/login']) ?>">Login</a></li>
                                                    <li class="showonmobile"><a href="<?= \yii\helpers\Url::to(['/site/signup']) ?>">Register</a></li>
                                                <?php } else { ?>
                                                    <li class="showonmobile"><a href="<?= \yii\helpers\Url::to(['/site/dashboard']) ?>">Dashboard</a></li>
                                                    <li class="showonmobile">
                                                        <form id="logout-form" method="post" action="<?= \yii\helpers\Url::to(['/site/logout']) ?>">
                                                            <?= \yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                                                            <button type="submit" class="logout-btn">Logout</button>
                                                        </form>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="Appointment">
                                        <?php if (Yii::$app->user->isGuest): ?>
                                            <div class="book_btn d-none d-lg-block">
                                                <a href="<?= \yii\helpers\Url::to(['/site/login']) ?>">Login</a>
                                            </div>
                                            <div style="margin-left:2px;" class="book_btn d-none d-lg-block">
                                                <a href="<?= \yii\helpers\Url::to(['/site/signup']) ?>">Register</a>
                                            </div>
                                        <?php else: ?>
                                            <div class="book_btn d-none d-lg-block">
                                                <a href="<?= \yii\helpers\Url::to(['/site/dashboard']) ?>">Dashboard</a>
                                            </div>
                                            <div class="book_btn d-none d-lg-block">
                                                <form id="logout-form" method="post" action="<?= \yii\helpers\Url::to(['/site/logout']) ?>">
                                                    <?= \yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                                                    <button type="submit" class="logout-btn">Logout</button>
                                                </form>
                                            </div>

                                        <?php endif; ?>

                                    </div>

                                    <!-- <div class="Appointment">
                                        <div class="book_btn d-none d-lg-block">
                                            <a href="#">Apply Now</a>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- News Ticker -->
    <div class="news-ticker">

        <div class="ticker-content" data-content="<?php
                                                    // Fetch the latest 10 news titles
                                                    $newsItems = News::find()
                                                        ->select(['title', 'description']) // Include description in the select
                                                        ->orderBy(['created_at' => SORT_DESC]) // Order by creation date descending
                                                        ->limit(10) // Limit to 10 items
                                                        ->all();

                                                    // Create a string of news titles with descriptions
                                                    $newsTitles = array_map(function ($item) {
                                                        // Return the title bolded and the description in normal font
                                                        return '' . $item->title . ': ' . ($item->description); // Encode to prevent XSS
                                                    }, $newsItems);

                                                    // Display the titles in the ticker
                                                    echo implode(' &nbsp;|&nbsp; ', $newsTitles);
                                                    ?>">
            <?php
            // Repeat the same content to ensure seamless scrolling
            echo implode(' &nbsp;|&nbsp; ', $newsTitles);
            ?>
        </div>
    </div>


    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->usertype == 'admin') {
    ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">For Admin only: </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="<?= \yii\helpers\Url::to(['/session/index']) ?>">all sessions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= \yii\helpers\Url::to(['/quiz/index']) ?>">all quiz</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= \yii\helpers\Url::to(['/user/index']) ?>">all users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= \yii\helpers\Url::to(['/session/allvideos']) ?>">all videos/lectures</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= \yii\helpers\Url::to(['/news/index']) ?>">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= \yii\helpers\Url::to(['/site/create-stream']) ?>">Live Stream</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= \yii\helpers\Url::to(['/site/reattempts-requests']) ?>">Requests Re Attempts</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    <?php
    } ?>
    <!-- Header End -->

    <!-- Main Content -->
    <!-- <main class="container"> -->
    <?= Alert::widget() ?>
    <div id="main-root">
        <?= $content ?>
    </div>
    <!-- </main> -->

    <!-- footer start -->
    <footer class="footer">
        <div class="footer_top">
            <div class="container">
                <div class="newsLetter_wrap">
                    <div class="row justify-content-between">
                        <div class="col-md-12 col-lg-5">
                            <div class="footer_widget">
                                <h3 class="footer_title">
                                    Connect Us
                                </h3>
                                <div class="socail_links">
                                    <ul>
                                        <li>
                                            <a target="_blank" href="https://www.facebook.com/profile.php?id=61563578886761&mibextid=ZbWKwL">
                                                <i class="ti-facebook"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a target="_blank" href="https://www.tiktok.com/@doctrcoachingacademy?_t=8qRtZumWD6V&_r=1">
                                                <i class="fa fa-tumblr"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a target="_blank" href="https://youtube.com/@medicomasterg?si=CVoD-YAHP2owEWSF">
                                                <i class="fa fa-youtube"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a target="_blank" href="https://www.instagram.com/p/C8cY307KXin/?igsh=MXhzN243Y3hieW1vdg==">
                                                <i class="fa fa-instagram"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                About Us
                            </h3>
                            <p class="text-white pt-2">
                                At PrimeMed Coaching, we provide top-notch education and training for future healthcare professionals. Our expert faculty and modern facilities prepare students to excel in the medical field. </p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Courses
                            </h3>
                            <ul>
                                <li><a href="<?= \yii\helpers\Url::to(['/site/signup']) ?>">USMLE Preparation</a></li>
                                <li><a href="<?= \yii\helpers\Url::to(['/site/signup']) ?>">FCPS Training</a></li>
                                <li><a href="<?= \yii\helpers\Url::to(['/site/signup']) ?>">PLAB Coaching</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-3 pt-0 pt-lg-5">
                        <div class="footer_widget">

                            <ul>
                                <li><a href="<?= \yii\helpers\Url::to(['/site/signup']) ?>">PMDC NER Guidance</a></li>
                                <li><a href="<?= \yii\helpers\Url::to(['/site/signup']) ?>">MD/MS Program</a></li>
                                <li><a href="<?= \yii\helpers\Url::to(['/site/signup']) ?>">PMDC NEB Guidance</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Links
                            </h3>
                            <ul>
                                <li><a href="<?= \yii\helpers\Url::to(['/site/index']) ?>">Home</a></li>
                                <li><a href="<?= \yii\helpers\Url::to(['/site/courses']) ?>">Courses</a></li>
                                <li><a href="<?= \yii\helpers\Url::to(['/site/contact']) ?>">Contact</a></li>
                                <li><a href="<?= \yii\helpers\Url::to(['/site/terms']) ?>">Terms And Conditions</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copy-right_text">
            <div class="container">
                <div class="footer_border"></div>
                <div class="row">
                    <div class="col-xl-12">
                        <p class="copy_right text-center">
                        <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;<script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | Developed by <a href="https://jantrah.com" target="_blank" class="text-white">Jantrah Tech</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer end  -->

    <!-- JS Files -->
    <script src="<?= Yii::getAlias('@web/js/vendor/modernizr-3.5.0.min.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/vendor/jquery-1.12.4.min.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/popper.min.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/bootstrap.min.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/owl.carousel.min.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/isotope.pkgd.min.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/ajax-form.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/waypoints.min.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/jquery.counterup.min.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/imagesloaded.pkgd.min.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/scrollIt.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/jquery.scrollUp.min.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/wow.min.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/nice-select.min.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/jquery.slicknav.min.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/jquery.magnific-popup.min.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/plugins.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/gijgo.min.js') ?>"></script>

    <!-- Contact JS -->
    <script src="<?= Yii::getAlias('@web/js/contact.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/jquery.ajaxchimp.min.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/jquery.form.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/jquery.validate.min.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/mail-script.js') ?>"></script>

    <script src="<?= Yii::getAlias('@web/js/main.js') ?>"></script>
    <script>
        document.querySelector("#yii-debug-toolbar")?.remove();
    </script>
    <?php
    $js = <<<JS
        document.querySelectorAll('.ticker-content').forEach(function(ticker) {
            const contentWidth = ticker.scrollWidth / 2; // Half because of ::after duplication
            const containerWidth = ticker.parentElement.offsetWidth;
            const duration = contentWidth / 50; // 50px per second for smooth scrolling
            ticker.style.animationDuration = duration + 's';
        });
        JS;
        $this->registerJs($js, \yii\web\View::POS_END);
    ?>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>