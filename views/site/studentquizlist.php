<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use app\models\QuizTimeLog;
use yii\bootstrap5\Html;
use yii\grid\GridView;
use yii\bootstrap5\ActiveForm;

$this->title = 'Quizzes List';
$this->params['breadcrumbs'][] = $this->title;
date_default_timezone_set('UTC');
?>

<div class="main-page">
    <div class="page-header">
        <h2><i class="fas fa-question"></i> <?= Html::encode($this->title) ?></h2>
    </div>
    <div class="page-content">
        <div class="card quizzes-card">
            <div class="card-header">
                <h6><i class="fas fa-list"></i> Available Quizzes</h6>
            </div>
            <div class="card-body">
            <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $quizData,
                        'pagination' => [
                            'pageSize' => 100,
                        ],
                    ]),
                    'options' => ['class' => 'table table-hover quizzes-table'],
                    'columns' => [
                        [
                            'label' => '',
                            'value' => function ($data) {
                                $endTimestamp = strtotime($data['quiz']->end_at);
                                $currentTimestamp = time();
                                $remainingTimeInSeconds = $endTimestamp - $currentTimestamp;

                                $btn = '';
                                $btn2 = '';
                                $video = '<a class="btn btn-link video-link" href="' . \yii\helpers\Url::to(['/site/subscribedlectures?id=' . $data['quiz']->id]) . '"><i class="fas fa-video"></i> View Lectures</a>';
                                $askReAttempt = "";

                                if ($remainingTimeInSeconds > 0) {
                                    if (!$data['attempted']) {
                                        $btn = Html::a(
                                            '<i class="fas fa-play"></i> Attempt this quiz',
                                            ['quiz/attempt-now', 'id' => $data['quiz']->id, 'session' => Yii::$app->request->get('id')],
                                            [
                                                'class' => 'btn btn-secondary start-btn',
                                                'data-id' => $data['quiz']->id,
                                                'id' => 'start-btn-' . $data['quiz']->id,
                                            ]
                                        );
                                    } else {
                                        $btn = Html::a('<i class="fas fa-check-circle"></i> View Results', ['quiz/result', 'id' => $data['quiz']->id], [
                                            'class' => 'btn btn-success',
                                            'data-id' => $data['quiz']->id,
                                        ]);
                                        $btn2 = Html::a(
                                            '<i class="fas fa-eye"></i> View Quiz',
                                            ['quiz/attempt-now', 'id' => $data['quiz']->id, 'session' => Yii::$app->request->get('id')],
                                            [
                                                'class' => 'btn btn-primary start-btn',
                                                'data-id' => $data['quiz']->id,
                                                'id' => 'start-btn-' . $data['quiz']->id,
                                            ]
                                        );
                                    }
                                } else {
                                    if ($data['attempted']) {
                                        $btn = Html::a('<i class="fas fa-check-circle"></i> View Results', ['quiz/result', 'id' => $data['quiz']->id], [
                                            'class' => 'btn btn-success',
                                            'data-id' => $data['quiz']->id,
                                        ]);
                                    }
                                }

                                $quizTime = QuizTimeLog::find()->where(['student_id' => Yii::$app->user->identity->id, 'quiz_id' => $data['quiz']->id])->one();
                                if ($quizTime) {
                                    $startTime = $quizTime->start_time;
                                    $endTime = $quizTime->log_time;

                                    $currentTime = date('Y-m-d H:i:s');
                                    $start = new DateTime($startTime);
                                    $end = new DateTime($currentTime);
                                    $interval = $start->diff($end);
                                    $duration = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

                                    if ($duration >= $quizTime->total_time) {
                                        $askReAttempt = Html::button(
                                            '<i class="fas fa-redo"></i> Re Attempt',
                                            [
                                                'class' => 'btn btn-warning reattempt-btn',
                                                'data-bs-toggle' => 'modal',
                                                'data-bs-target' => '#reattemptModal',
                                                'data-quiz-id' => $data['quiz']->id,
                                                'id' => 'reattempt-btn-' . $data['quiz']->id,
                                            ]
                                        );
                                        $btn2 = "";
                                    }
                                }

                                $duration = Html::encode($data['quiz']->duration_in_minutes);
                                $startTime = Yii::$app->formatter->asDatetime($data['quiz']->start_at, 'php:d M Y h:i A');
                                $endTime = Yii::$app->formatter->asDatetime($data['quiz']->end_at, 'php:d M Y h:i A');

                                $timeStatus = $remainingTimeInSeconds <= 0
                                    ? '<span class="time-up">Time Up</span>'
                                    : '<span id="remaining-time-' . $data['quiz']->id . '" class="time-remaining">Calculating...</span>';

                                $h = '<div class="quiz-info">' .
                                    '<h5 class="quiz-title">' . $data['quiz']->title . '<span style="font-size:0.8rem;"> (' . $data['quiz']->session->name . ')</span></h5>' .
                                    '<p class="quiz-description">' . $data['quiz']->description . '</p>' .
                                    '<p class="quiz-duration"><i class="fas fa-clock"></i> Duration: <span>' . $duration . ' min</span></p>' .
                                    '<p class="quiz-time"><i class="fas fa-calendar"></i> Available: ' . $startTime . ' to ' . $endTime . '</p>' .
                                    '<p class="quiz-remaining"><i class="fas fa-hourglass-half"></i> Remaining: ' . $timeStatus . '</p>' .
                                    '<div class="quiz-actions">' . $btn . ' ' . $btn2 . ' ' . $askReAttempt . ' ' . $video . '</div>' .
                                    '</div>';

                                return $h;
                            },
                            'format' => 'raw',
                        ],
                    ],
                ]); ?>
            </div>
        </div>

        <!-- Reattempt Modal -->
        <div class="modal fade" id="reattemptModal" tabindex="-1" aria-labelledby="reattemptModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reattemptModalLabel"><i class="fas fa-redo"></i> Request Reattempt</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <?php $form = ActiveForm::begin([
                        'id' => 'reattempt-form',
                        'action' => ['site/request-reattempt'],
                        'options' => ['data-pjax' => '0'],
                    ]); ?>
                    <div class="modal-body">
                        <?= $form->field($reattemptModel ?? new \app\models\Reattempts(), 'quiz_id')->hiddenInput(['id' => 'reattempt-quiz-id'])->label(false) ?>
                        <?= $form->field($reattemptModel ?? new \app\models\Reattempts(), 'reason')->textarea(['rows' => 4, 'placeholder' => 'Explain why you need a reattempt...']) ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <?= Html::submitButton('Submit Request', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
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
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-content {
        width: 100%;
    }

    .quizzes-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .quizzes-card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        background: #234262;
        color: #fff;
        padding: 15px;
        border-radius: 10px 10px 0 0;
        font-size: 1.2rem;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h6 {
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-body {
        padding: 20px;
    }

    .quizzes-table {
        margin: 0;
        border: none;
    }

    .quizzes-table td {
        padding: 15px;
        vertical-align: top;
        border-color: #e0e0e0;
    }

    .quizzes-table tr {
        transition: background 0.3s ease;
    }

    .quizzes-table tr:hover {
        background: #f9f9f9;
    }

    .quiz-info {
        color: #333;
    }

    .quiz-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #234262;
        margin-bottom: 5px;
    }

    .quiz-description {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 10px;
    }

    .quiz-duration,
    .quiz-time,
    .quiz-remaining {
        font-size: 0.95rem;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .quiz-duration span,
    .quiz-time span {
        font-weight: 500;
        color: #234262;
    }

    .time-remaining {
        font-weight: 500;
        color: #2a5298;
    }

    .time-up {
        font-weight: 500;
        color: #dc3545;
    }

    .quiz-actions {
        margin-top: 10px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 8px 15px;
        border-radius: 5px;
        font-size: 0.95rem;
        transition: background 0.3s ease;
    }

    .btn-secondary {
        background: #6c757d;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .btn-success {
        background: #28a745;
    }

    .btn-success:hover {
        background: #218838;
    }

    .btn-primary {
        background: #234262;
    }

    .btn-primary:hover {
        background: #2a5298;
    }

    .btn-warning {
        background: #ffc107;
        color: #212529;
    }

    .btn-warning:hover {
        background: #e0a800;
    }

    .btn-link {
        color: #234262;
        text-decoration: none;
        padding: 0;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .btn-link:hover {
        color: #2a5298;
        text-decoration: underline;
    }

    .view-lectures {
        color: #fff;
        font-size: 0.95rem;
    }

    .view-lectures:hover {
        color: #dcdcdc;
    }

    /* Modal Styles */
    .modal {
        z-index: 1055 !important;
    }

    .modal-backdrop {
        z-index: 1050 !important;
    }

    .modal-content {
        border-radius: 10px;
        position: relative;
        z-index: 1060;
    }

    .modal-header {
        background: #234262;
        color: #fff;
        border-bottom: none;
    }

    .modal-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        border-top: none;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header h2 {
            font-size: 1.5rem;
        }

        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .quizzes-table td {
            padding: 10px;
        }

        .quiz-title {
            font-size: 1.1rem;
        }

        .quiz-description,
        .quiz-duration,
        .quiz-time,
        .quiz-remaining {
            font-size: 0.85rem;
        }
    }

    @media (max-width: 576px) {
        .main-page {
            padding: 10px;
        }

        .page-header {
            padding: 15px;
        }

        .quizzes-table td {
            display: block;
            padding: 15px;
            border: none;
            border-bottom: 1px solid #e0e0e0;
        }

        .quiz-actions {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .btn {
            width: 100%;
            text-align: center;
        }

        .btn-link {
            width: auto;
        }
    }
</style>

<?php
// Register JavaScript for remaining time countdown and modal handling
$js = '';

date_default_timezone_set('Asia/Karachi');
foreach ($quizData as $data) {
    $endTimestamp = strtotime($data['quiz']->end_at);
    $currentTimestamp = time();
    $remainingTimeInSeconds = $endTimestamp - $currentTimestamp;

    $js .= "
            var remainingTimeInSeconds_{$data['quiz']->id} = $remainingTimeInSeconds;
     function updateRemainingTime_{$data['quiz']->id}() {
                if (remainingTimeInSeconds_{$data['quiz']->id} > 0) {
                    document.getElementById('remaining-time-{$data['quiz']->id}').textContent = formatTime_{$data['quiz']->id}(remainingTimeInSeconds_{$data['quiz']->id});
                    remainingTimeInSeconds_{$data['quiz']->id}--;
                } else {
                    document.getElementById('start-btn-{$data['quiz']->id}')?.remove();
                    document.getElementById('reattempt-btn-{$data['quiz']->id}')?.remove();
                    document.getElementById('remaining-time-{$data['quiz']->id}').textContent = 'Time Up';
                    document.getElementById('remaining-time-{$data['quiz']->id}').className = 'time-up';
                }
            }
    ";

    if ($remainingTimeInSeconds > 0) {
        $js .= "
            function formatTime_{$data['quiz']->id}(seconds) {
                var years = Math.floor(seconds / (3600 * 24 * 365));
                var months = Math.floor((seconds % (3600 * 24 * 365)) / (3600 * 24 * 30));
                var days = Math.floor((seconds % (3600 * 24 * 30)) / (3600 * 24));
                var hours = Math.floor((seconds % (3600 * 24)) / 3600);
                var minutes = Math.floor((seconds % 3600) / 60);
                var sec = seconds % 60;
                return (years > 0 ? years + 'y ' : '') + 
                       (months > 0 ? months + 'm ' : '') + 
                       (days > 0 ? days + 'd ' : '') + 
                       (hours > 0 ? hours + 'h ' : '') + 
                       (minutes > 0 ? minutes + 'm ' : '') + 
                       sec + 's';
            }
           
            updateRemainingTime_{$data['quiz']->id}(); // Initial call
            setInterval(updateRemainingTime_{$data['quiz']->id}, 1000);
        ";
    } else {
        $js .= "
        updateRemainingTime_{$data['quiz']->id}(); // Initial call
        ";
    }
}

$js .= <<<JS
    document.querySelectorAll('.reattempt-btn').forEach(button => {
        button.addEventListener('click', function() {
            const quizId = this.getAttribute('data-quiz-id');
            document.getElementById('reattempt-quiz-id').value = quizId;
        });
    });

    // document.getElementById('reattempt-form').addEventListener('submit', function(e) {
    //     e.preventDefault();
    //     const formData = new FormData(this);
        
    //     fetch(this.action, {
    //         method: 'POST',
    //         body: formData,
    //         headers: {
    //             'X-CSRF-Token': yii.getCsrfToken()
    //         }
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         if (data.success) {
    //             alert('Reattempt request submitted successfully!');
    //             $('#reattemptModal').modal('hide');
    //         } else {
    //             alert('Error: ' + (data.message || 'Submission failed.'));
    //         }
    //     })
    //     .catch(error => {
    //         alert('Error: ' + error.message);
    //     });
    // });
JS;

$this->registerJs($js, \yii\web\View::POS_END);

// Register Bootstrap JS and jQuery
$this->registerJsFile('https://code.jquery.com/jquery-3.6.0.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>