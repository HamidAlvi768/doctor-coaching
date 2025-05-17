<?php
/** @var yii\web\View $this */
/** @var app\models\Stream $stream */

use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Live Stream';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="main-page">
    <div class="page-header">
        <h2><i class="fas fa-video"></i> <?= Html::encode($this->title) ?></h2>
    </div>
    <div class="page-content">
        <div class="stream-details">
            <p>
            <h3>Live Stream Details:</h3>
            </p>
            <?php if ($stream): ?>
                <p><strong>Start:</strong> <span><?= date('F j, Y h:i A', strtotime($stream->start_time)) ?></span></p>
                <p><strong>End:</strong> <span><?= date('F j, Y h:i A', strtotime($stream->end_time)) ?></span></p>
                <p><strong>Status:</strong> <span id="stream-status"></span></p>
                <p><strong>Time Remaining:</strong> <span id="remaining-time"></span></p>
            <?php endif; ?>
        </div>

        <div class="live-stream-video-container">
            <?php if ($stream): ?>
                <?php if ($stream->stream_type == "youtube"): ?>
                    <div class="live-stream-container">
                        <div style="position:relative;padding-bottom:56.25%;overflow:hidden;height:0;max-width:100%;">
                            <iframe id="stream-iframe"
                                src="<?= Html::encode($stream->stream_url) ?>"
                                width="100%" height="100%" frameborder="0" scrolling="no"
                                allow="autoplay;encrypted-media" allowfullscreen
                                webkitallowfullscreen mozallowfullscreen oallowfullscreen msallowfullscreen
                                style="position:absolute;top:0;left:0;"></iframe>
                        </div>
                    </div>

                <?php elseif ($stream->stream_type == "zoom"): ?>
                    <div class="container text-center">
                        <p id="meeting-message">Check meeting time above.</p>
                        <a href="<?= Url::to(['zoom/meeting']) ?>" class="btn btn-primary" id="meeting-button" style="display: none;">Go to Meeting</a>
                    </div>

                <?php endif; ?>
            <?php else: ?>
                <div class="container">
                    <p><strong>There is no Live Stream scheduled yet.</strong></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Existing styles remain unchanged -->
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
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-content {
        width: 100%;
    }

    .stream-details {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .stream-details h3 {
        font-size: 1.5rem;
        color: #234262;
        margin-bottom: 15px;
    }

    .stream-details p {
        font-size: 1.1rem;
        margin: 5px 0;
    }

    .stream-details strong {
        color: #2a5298;
    }

    .live-stream-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    #stream-iframe {
        width: 100%;
        height: 100%;
        border-radius: 5px;
    }

    .container {
        text-align: center;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    #remaining-time,
    #stream-status {
        color: #e94560;
        font-weight: 500;
    }

    body {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-touch-callout: none;
    }
</style>

<?php if ($stream): ?>
    <?php
    $startTime = $stream->start_time;
    $endTime = $stream->end_time;
    $streamType = $stream->stream_type;
    $this->registerJs(<<<JS
        // Existing security-related JavaScript remains unchanged
        document.addEventListener('contextmenu', event => {
            event.preventDefault();
            //changeContent();
        });

        document.onkeydown = function(e) {
            if (e.key === "F12" || 
                (e.ctrlKey && e.shiftKey && e.key === "I") || 
                (e.ctrlKey && e.shiftKey && e.key === "J") || 
                (e.ctrlKey && e.key === "U") || 
                (e.ctrlKey && e.shiftKey && e.key === "E") ||
                (e.ctrlKey && e.shiftKey && e.key === "C")) {
                e.preventDefault();
                changeContent();
                alert("Access to developer tools and source is restricted.");
                return false;
            }
        };

        document.addEventListener('copy', event => {
            event.preventDefault();
            alert("Copying is disabled.");
        });

        document.addEventListener('dragstart', event => event.preventDefault());

        function detectDevTools() {
            let threshold = 160;
            let widthThreshold = window.outerWidth - window.innerWidth > threshold;
            let heightThreshold = window.outerHeight - window.innerHeight > threshold;

            if (widthThreshold || heightThreshold) {
                changeContent();
            }
        }

        setInterval(detectDevTools, 500);

        window.onblur = function() {
            document.body.style.filter = "blur(10px)";
            setTimeout(() => {
                document.body.style.filter = "none";
            }, 1500);
        };

        // document.addEventListener('mousemove', (e) => {
        //     if (e.clientX < 10 || e.clientY < 10 || e.clientX > window.innerWidth - 10 || e.clientY > window.innerHeight - 10) {
        //         changeContent();
        //     }
        // });

        function changeContent() {
            document.body.innerHTML = `
                <div style="text-align:center;padding:50px;color:#fff;background:#e94560;border-radius:10px;">
                    <h1>Access Denied</h1>
                    <p>Unauthorized access detected. Please refrain from inspecting this page.</p>
                </div>
            `;
            document.body.style.backgroundColor = "#333";
        }

        // Updated stream time update logic
        function updateStreamTime() {
            const startTime = new Date('$startTime').getTime();
            const endTime = new Date('$endTime').getTime();
            const now = new Date().getTime();
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const startDate = new Date('$startTime');
            startDate.setHours(0, 0, 0, 0);
            const isZoom = '$streamType' === 'zoom';

            const timeToStart = startTime - now;
            const timeToEnd = endTime - now;

            const statusElement = document.getElementById('stream-status');
            const remainingElement = document.getElementById('remaining-time');
            const meetingButton = document.getElementById('meeting-button');
            const meetingMessage = document.getElementById('meeting-message');

            if (!statusElement || !remainingElement) return;

            // Check if today is the same as start date
            const isToday = startDate.getTime() === today.getTime();

            // Function to format remaining time
            function formatRemainingTime(timeDiff) {
                const years = Math.floor(timeDiff / (1000 * 60 * 60 * 24 * 365));
                const months = Math.floor((timeDiff % (1000 * 60 * 60 * 24 * 365)) / (1000 * 60 * 60 * 24 * 30));
                const days = Math.floor((timeDiff % (1000 * 60 * 60 * 24 * 30)) / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));

                let parts = [];
                if (years) parts.push(years + ' year' + (years > 1 ? 's' : ''));
                if (months) parts.push(months + ' month' + (months > 1 ? 's' : ''));
                if (days) parts.push(days + ' day' + (days > 1 ? 's' : ''));
                if (hours) parts.push(hours + ' hour' + (hours > 1 ? 's' : ''));
                if (minutes) parts.push(minutes + ' minute' + (minutes > 1 ? 's' : ''));

                return parts.length ? parts.join(', ') : 'Less than a minute';
            }

            if (timeToStart > 0) {
                const remainingText = formatRemainingTime(timeToStart);
                if (isZoom) {
                    if (isToday) {
                        statusElement.innerText = 'Scheduled for Today';
                        meetingMessage.innerText = 'Meeting starts in '+ remainingText;
                        if (meetingButton) meetingButton.style.display = 'inline-block';
                    } else {
                        statusElement.innerText = 'Not Started';
                        meetingMessage.innerText = 'Meeting is scheduled in '+ remainingText;
                        if (meetingButton) meetingButton.style.display = 'none';
                    }
                } else {
                    statusElement.innerText = 'Not Started';
                }
                remainingElement.innerText = remainingText;
            } else if (timeToEnd > 0) {
                statusElement.innerText = isZoom ? 'Meeting In Progress' : 'Live Now';
                remainingElement.innerText = isZoom ? 'Meeting is currently in progress.' : 'Stream is currently live.';
                if (isZoom && meetingButton) {
                    meetingButton.style.display = 'inline-block';
                    meetingMessage.innerText = 'Meeting is currently in progress. Join now!';
                }
            } else {
                statusElement.innerText = isZoom ? 'Meeting Ended' : 'Ended';
                remainingElement.innerText = isZoom ? 'The meeting has ended.' : 'Stream has ended.';
                if (isZoom && meetingButton) {
                    meetingButton.style.display = 'none';
                    meetingMessage.innerText = 'The meeting has ended.';
                }
                clearInterval(timer);
            }
        }

        // Initial call and timer
        updateStreamTime();
        const timer = setInterval(updateStreamTime, 1000);
    JS, \yii\web\View::POS_END);
    ?>
<?php endif; ?>