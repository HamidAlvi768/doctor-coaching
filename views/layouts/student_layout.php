<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Html;
use yii\helpers\Url;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/img/logo.png')]);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="no-js">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PrimeMed Coaching | <?= Html::encode($this->title) ?></title>
    <link rel="icon" href="<?= Yii::getAlias('@web/img/logo.png') ?>" type="image/png">
    <?php $this->head() ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/bootstrap.min.css') ?>">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Header Styles */
        .header-area {
            background: #fafafa;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header_wrap {
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .header_left .logo img {
            height: 45px;
            width: 50px;
        }

        .header_right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* Dropdown Styles */
        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .profile-btn {
            background: none;
            border: none;
            color: #1e3c72;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-btn img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #fff;
            min-width: 150px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            z-index: 1;
        }

        .dropdown-content a,
        .dropdown-content form button {
            color: #333;
            padding: 10px 15px;
            text-decoration: none;
            display: block;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-content a:hover,
        .dropdown-content form button:hover {
            background-color: #f1f1f1;
        }

        .profile-dropdown:hover .dropdown-content {
            display: block;
        }

        .website-link {
            color: #234262;
        }

        .website-link:hover {
            color: #2a5298;
        }

        /* Main Container */
        .main-container {
            display: flex;
            min-height: calc(100vh - 80px);
            transition: all 0.3s ease;
        }

        /* Sidebar Styles */
        .left-sidebar {
            width: 250px;
            background: linear-gradient(135deg, #234262, #2a5298);
            color: #fff;
            height: calc(100vh - 60px);
            position: fixed;
            top: 60px;
            left: 0;
            padding-top: 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 900;
        }

        .left-sidebar a {
            text-decoration: none;
            color: #dcdcdc;
            display: flex;
            align-items: center;
            padding: 15px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .left-sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            padding-left: 25px;
        }

        .left-sidebar a.active {
            background: linear-gradient(45deg, black, transparent);
        }

        .left-sidebar a i {
            margin-right: 10px;
            font-size: 18px;
        }

        .left-sidebar .dashboard-link {
            background-color: rgba(255, 255, 255, 0.2);
            font-size: 18px;
            font-weight: 600;
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 10px;
            left: 15px;
            z-index: 1100;
            color: #1e3c72;
            border: none;
            width: 45px;
            height: 45px;
            justify-content: center;
            align-items: center;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Right Content */
        .right-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
            background: #fff;
            min-height: calc(100vh - 80px);
            transition: all 0.3s ease;
        }

        /* Responsive Design */
        @media (max-width: 991px) {
            .header_left {
                margin-left: 80px;
            }

            .left-sidebar {
                width: 0;
                overflow: hidden;
            }

            .left-sidebar.active {
                width: 250px;
            }

            .right-content {
                margin-left: 0;
                width: 100%;
            }

            .sidebar-toggle {
                display: flex;
            }

            .header_wrap {
                padding: 10px;
            }

            .header_right {
                gap: 10px;
            }
        }

        @media (max-width: 576px) {
            .header_left .logo h5 {
                font-size: 14px;
            }

            .profile-btn img {
                width: 25px;
                height: 25px;
            }

            .profile-btn {
                font-size: 16px;
            }

            .dropdown-content {
                min-width: 120px;
            }
            .right-content {
            padding: 0px;
        }
        }
    </style>
</head>

<body>
    <?php $this->beginBody() ?>

    <!-- Header Start -->
    <header class="header-area">
        <div class="header_wrap">
            <div class="header_left">
                <div class="logo">
                    <a class="d-flex align-items-center" href="<?= Yii::$app->homeUrl ?>">
                        <img src="<?= Yii::getAlias('@web/img/logo.png') ?>" alt="">
                        <h5 class="m-1 ml-3" style="color:#234262;font-weight:600;font-size:20px;text-decoration:none;">PrimeMed Coaching</h5>
                    </a>
                </div>
            </div>
            <div class="header_right">
                <?php if (Yii::$app->user->isGuest): ?>
                    <a href="<?= Url::to(['/site/login']) ?>" class="btn btn-primary btn-sm">Login</a>
                    <a href="<?= Url::to(['/site/signup']) ?>" class="btn btn-outline-primary btn-sm ml-2">Register</a>
                <?php else: ?>
                    <a href="<?= Url::to(['/site/index']) ?>" class="btn btn-outline-primary btn-sm website-link"><i class="fas fa-globe"></i></a>
                    <div class="profile-dropdown">
                        <button class="profile-btn">
                            <img src="<?= Yii::getAlias('@web/img/user.png') ?>" alt="Profile"> <!-- Replace with dynamic user image if available -->
                            <i class="fas fa-caret-down"></i>
                        </button>
                        <div class="dropdown-content">
                            <a href="<?= Url::to(['site/profile']) ?>">
                                <i class="fas fa-user"></i> Profile
                            </a>
                            <form id="logout-form" method="post" action="<?= Url::to(['/site/logout']) ?>">
                                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                                <button type="submit">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <?= Alert::widget() ?>
    <style>
        .alert {
            position: absolute;
            right: 10px;
            margin: 20px;
            z-index: 999;
        }
    </style>

    <?php $action = $this->context->action->id ?>

    <!-- Main Content with Sidebar -->
    <button class="sidebar-toggle"><i class="fas fa-bars"></i></button>    <div class="main-container">
        <div class="left-sidebar">
            <a href="<?= Url::to(['site/dashboard']) ?>" class="dashboard-link <?php echo $action=='dashboard'?'active':'' ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="<?= Url::to(['site/sessions']) ?>" class="side-link <?php echo $action=='sessions'?'active':'' ?>"><i class="fas fa-calendar-alt"></i> Sessions</a>
            <a href="<?= Url::to(['site/lectures']) ?>" class="side-link <?php echo $action=='lectures'?'active':'' ?>"><i class="fas fa-video"></i> Lectures</a>
            <a href="<?= Url::to(['site/quizez']) ?>" class="side-link <?php echo $action=='quizez'?'active':'' ?>"><i class="fas fa-list"></i> Quiz</a>
            <a href="<?= Url::to(['site/live-stream']) ?>" class="side-link <?php echo $action=='live-stream'?'active':'' ?>"><i class="fas fa-play-circle"></i> Live Stream</a>
            <!-- <a href="<?= Url::to(['site/attempted-quiz']) ?>" class="side-link"><i class="fas fa-check"></i> Attempted Quiz</a> -->
            <a href="<?= Url::to(['site/profile']) ?>" class="side-link <?php echo $action=='profile'?'active':'' ?>"><i class="fas fa-user"></i> Profile</a>
            <a href="" class="side-link" style="padding-right:0px;padding-top:0px;padding-bottom:0px;">
                <form id="logout-form" method="post" action="<?= Url::to(['/site/logout']) ?>" style="width: 100%;height:100%;">
                    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                    <button type="submit" style="width:100%;height:45px;border:none;outline:none;background:none;color:white;text-align:left;padding:0px;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </a>
        </div>
        <div class="right-content">
            <?= $content ?>
        </div>
    </div>

    <!-- Footer Start (Unstyled as Requested) -->
    <footer class="footer">
        <div class="copy-right_text">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <p class="copy_right text-center">
                            Copyright © <script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | Developed by <a href="https://jantrah.com" target="_blank" class="text-success">Jantrah Tech</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JS Files -->
    <script src="<?= Yii::getAlias('@web/js/vendor/jquery-1.12.4.min.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/bootstrap.min.js') ?>"></script>
    <script src="<?= Yii::getAlias('@web/js/main.js') ?>"></script>
    <script>
        document.querySelector("#yii-debug-toolbar")?.remove();
    </script>
    <script>
        $(document).ready(function() {
            $('.sidebar-toggle').click(function() {
                $('.left-sidebar').toggleClass('active');
                $('.right-content').toggleClass('sidebar-active');
            });
        });
    </script>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>