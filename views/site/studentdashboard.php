<?php
/** @var yii\web\View $this */
/** @var string $content */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\helpers\Url;

$profileUrl = Url::to(['site/profile']);
$this->title = 'Student Dashboard';
$this->params['breadcrumbs'][] = $this->title;

// Register Font Awesome
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css', ['position' => \yii\web\View::POS_HEAD]);
?>

<div class="main-page">
    <div class="page-header">
        <h2><i class="fas fa-tachometer-alt"></i> <?= Html::encode($this->title) ?></h2>
    </div>
    <div class="page-content">
        <!-- STATS -->
        <div class="dashboard-stats">
            <div class="card stat-card">
                <div class="card-body">
                    <i class="fas fa-calendar-alt stat-icon"></i>
                    <h4>Sessions</h4>
                    <p><strong><?= $sessionCount; ?></strong></p>
                </div>
            </div>
            <div class="card stat-card">
                <div class="card-body">
                    <i class="fas fa-video stat-icon"></i>
                    <h4>Lectures</h4>
                    <p><strong><?= $lectureCount; ?></strong></p>
                </div>
            </div>
        </div>
        <!-- END STATS -->

        <div class="row page-content-2">
            <div class="col-md-4 mb-4">
                <div class="heading-4">
                    <h4><i class="fas fa-bullhorn"></i> News</h4>
                    <div class="button-container">
                        <button class="nav-button" id="prevBtn"><i class="fas fa-chevron-left"></i></button>
                        <button class="nav-button" id="nextBtn"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
                <div class="news-container">
                    <?php foreach ($newsItems as $key => $item): ?>
                        <div class="news-item" style="display: none;">
                            <h5 class="news-title"><?= $item['title'] ?></h5>
                            <p><?= $item['description'] ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-8 mb-4">
                <div class="heading-4">
                    <h4><i class="fas fa-tasks"></i> New Assigned Sessions <small>(Previous <?= $days ?> days)</small></h4>
                </div>
                <div class="sessions-container">
                    <?php if (empty($assigned)): ?>
                        <p class="no-data">No new assigned sessions.</p>
                    <?php else: ?>
                        <div class="sessions-list">
                            <?php foreach ($assigned as $key => $as): ?>
                                <?php if ($as->session): ?>
                                    <div class="session-card">
                                        <div class="session-number"><?= $key + 1 ?></div>
                                        <div class="session-details">
                                            <h5 class="session-title">
                                                <?= Html::a(Html::encode($as->session->name), ['site/quizlist', 'id' => $as->session->id], [
                                                    'class' => 'session-link',
                                                ]); ?>
                                            </h5>
                                            <p class="session-date">
                                                <i class="fas fa-calendar"></i> 
                                                <?= date('d M Y', strtotime($as->session->start_time)) . ' - ' . date('d M Y', strtotime($as->session->end_time)) ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .main-page {
        width: 100%;
        padding: 20px;
        font-family: 'Poppins', sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, #234262, #2a5298);
        color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .page-header h2 {
        font-size: 1.8rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-content {
        width: 100%;
    }

    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .stat-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .stat-card .card-body {
        padding: 20px;
        text-align: center;
    }

    .stat-icon {
        font-size: 2rem;
        color: #234262;
        margin-bottom: 10px;
    }

    .stat-card h4 {
        color: #234262;
        font-size: 1.2rem;
        margin-bottom: 10px;
    }

    .stat-card p {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        margin: 0;
    }

    .page-content-2 {
        margin: 20px 0;
    }

    .heading-4 {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .heading-4 h4 {
        color: #234262;
        font-size: 1.2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .heading-4 small {
        color: #666;
        font-size: 0.9rem;
    }

    .button-container {
        display: flex;
        gap: 5px;
    }

    .nav-button {
        background: #234262;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .nav-button:hover {
        background: #2a5298;
    }

    .news-container {
        border: 1px solid #e0e0e0;
        padding: 15px;
        min-height: 300px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .news-item h5 {
        color: #234262;
        font-size: 1.1rem;
        margin-bottom: 10px;
    }

    .news-item p {
        color: #555;
        font-size: 0.95rem;
    }

    .sessions-container {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 15px;
    }

    .no-data {
        color: #666;
        font-style: italic;
        text-align: center;
        padding: 15px;
    }

    /* Desktop Table Layout */
    @media (min-width: 769px) {
        .sessions-list {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .session-card {
            display: table-row;
        }

        .session-number,
        .session-details {
            display: table-cell;
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #e0e0e0;
        }

        .session-number {
            width: 10%;
            text-align: center;
            font-weight: 600;
            color: #234262;
        }

        .session-details {
            width: 90%;
        }

        .session-title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .session-date {
            margin: 5px 0 0 0;
            font-size: 0.95rem;
            color: #333;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sessions-list .session-card:hover {
            background: #f9f9f9;
        }
    }

    /* Mobile Card Layout */
    @media (max-width: 768px) {
        .sessions-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .session-card {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 12px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .session-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .session-number {
            width: 35px;
            height: 35px;
            line-height: 35px;
            text-align: center;
            background: #234262;
            color: #fff;
            border-radius: 50%;
            font-size: 1rem;
            flex-shrink: 0;
            margin-right: 10px;
        }

        .session-details {
            flex: 1;
        }

        .session-title {
            margin: 0;
            font-size: 1rem;
            font-weight: 500;
            color: #234262;
        }

        .session-date {
            margin: 5px 0 0 0;
            font-size: 0.9rem;
            color: #333;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    }

    .session-link {
        color: #234262;
        text-decoration: none;
        padding: 5px 10px;
        border-radius: 5px;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .session-link:hover {
        color: #2a5298;
        background: #e8eef5;
        text-decoration: none;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .page-header h2 {
            font-size: 1.5rem;
        }

        .dashboard-stats {
            grid-template-columns: 1fr;
        }

        .stat-card .card-body {
            padding: 15px;
        }

        .stat-icon {
            font-size: 1.8rem;
        }

        .stat-card h4 {
            font-size: 1.1rem;
        }

        .stat-card p {
            font-size: 1.3rem;
        }

        .heading-4 h4 {
            font-size: 1.1rem;
        }

        .news-container {
            min-height: 250px;
        }

        .page-content-2 .col-md-4,
        .page-content-2 .col-md-8 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    @media (max-width: 576px) {
        .main-page {
            padding: 15px;
        }

        .page-header {
            padding: 15px;
        }

        .sessions-container {
            padding: 10px;
        }

        .session-card {
            padding: 10px;
        }

        .session-number {
            width: 30px;
            height: 30px;
            line-height: 30px;
            font-size: 0.9rem;
        }

        .session-title {
            font-size: 0.95rem;
        }

        .session-date {
            font-size: 0.85rem;
        }

        .session-link {
            padding: 5px 8px;
        }
    }
</style>

<script>
    const newsItems = document.querySelectorAll('.news-item');
    let currentIndex = 0;
    let autoCycleTimer = null;

    function clearAutoCycle() {
        if (autoCycleTimer) {
            clearTimeout(autoCycleTimer);
            autoCycleTimer = null;
        }
    }

    function typeWriter(text, element, speed = 50) {
        return new Promise(resolve => {
            element.textContent = '';
            element.parentElement.style.display = 'block';
            let i = 0;
            const timer = setInterval(() => {
                if (i < text.length) {
                    element.textContent += text.charAt(i);
                    i++;
                } else {
                    clearInterval(timer);
                    resolve();
                }
            }, speed);
        });
    }

    function scheduleNextItem() {
        clearAutoCycle();
        autoCycleTimer = setTimeout(() => {
            currentIndex = (currentIndex + 1) % newsItems.length;
            showNewsItem(currentIndex);
        }, 5000);
    }

    async function showNewsItem(index) {
        clearAutoCycle();

        newsItems.forEach(item => item.style.display = 'none');

        const currentItem = newsItems[index];
        const titleElement = currentItem.querySelector('.news-title');
        const descElement = currentItem.querySelector('p');

        if (!titleElement.getAttribute('data-title')) {
            titleElement.setAttribute('data-title', titleElement.textContent);
        }
        if (!descElement.getAttribute('data-desc')) {
            descElement.setAttribute('data-desc', descElement.textContent);
        }

        const titleText = titleElement.getAttribute('data-title');
        const descText = descElement.getAttribute('data-desc');

        titleElement.textContent = '';
        descElement.textContent = '';

        await typeWriter(titleText, titleElement);
        await typeWriter(descText, descElement, 80);

        document.getElementById('prevBtn').disabled = index === 0;
        document.getElementById('nextBtn').disabled = index === newsItems.length - 1;

        scheduleNextItem();
    }

    document.getElementById('prevBtn').addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            showNewsItem(currentIndex);
        }
    });

    document.getElementById('nextBtn').addEventListener('click', () => {
        if (currentIndex < newsItems.length - 1) {
            currentIndex++;
            showNewsItem(currentIndex);
        } else {
            currentIndex = 0;
            showNewsItem(currentIndex);
        }
    });

    showNewsItem(currentIndex);
</script>