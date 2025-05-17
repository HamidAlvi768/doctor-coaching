<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\Html;

$this->title = 'Quizzes List';
$this->params['breadcrumbs'][] = $this->title;

// $correctCount = 0;
// $wrongCount = 0;

// foreach ($data as $row) {
//     if ($row['correct'] === 'correct answer') {
//         $correctCount++;
//     } elseif ($row['correct'] === 'wrong answer') {
//         $wrongCount++;
//     }
// }
?>

<div class="main-page">
    <div class="page-header">
        <h2><i class="fas fa-clipboard-check"></i> Quiz Result</h2>
    </div>
    <div class="page-content">
        <div class="card result-card">
            <div class="card-header">
                <h4><i class="fas fa-list-ol"></i> Quiz Result</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover result-table">
                    <!-- <thead>
                        <tr>
                            <th>Question No</th>
                            <th>Answer Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php //foreach ($data as $row): 
                        ?>
                            <tr>
                                <td><?php //$row['qn'] 
                                    ?></td>
                                <td>
                                    <span class="<?php // $row['correct'] === 'correct answer' ? 'correct' : 'wrong' 
                                                    ?>">
                                        <i class="fas <?php //$row['correct'] === 'correct answer' ? 'fa-check' : 'fa-times' 
                                                        ?>"></i>
                                        <?php // ucfirst(//$row['correct']) 
                                        ?>
                                    </span>
                                </td>
                            </tr>
                        <?php //endforeach; 
                        ?>
                    </tbody> -->
                    <tfoot>
                        <tr>
                            <td><strong><i class="fas fa-question"></i> Total Questions:</strong></td>
                            <td><?= $data['totalQuestion'] ?></td>
                        </tr>
                        <tr>
                            <td><strong><i class="fas fa-check-circle"></i> Total Correct:</strong></td>
                            <td><?= $data['totalCorrect'] ?></td>
                        </tr>
                        <tr>
                            <td><strong><i class="fas fa-xmark"></i> Total Wrong:</strong></td>
                            <td><?= $data['totalIncorrect'] ?></td>
                        </tr>
                        <tr>
                            <td><strong><i class="fas fa-minus"></i> Total Unattempted:</strong></td>
                            <td><?= $data['unAttempted'] ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <?php if (isset($videos) && !empty($videos)): ?>
            <div class="related-videos mt-5">
                <div class="card videos-card">
                    <div class="card-header">
                        <h4><i class="fas fa-video"></i> Related Videos</h4>
                    </div>
                    <div class="card-body">
                        <?php foreach ($videos as $v): ?>
                            <?php
                            $encryptedId = Yii::$app->security->encryptByKey($v->id, 'rmabsalibaig');
                            $encryptedId = base64_encode($encryptedId);
                            ?>
                            <div class="video-row">
                                <p class="video-title">
                                    <i class="fas fa-film"></i> <?= $v->title ?>
                                    <span class="video-action">
                                        <a class="btn btn-success" href="<?= \yii\helpers\Url::to(['quiz/playvideo', 'id' => $encryptedId]) ?>">
                                            <i class="fas fa-play"></i> Watch Video
                                        </a>
                                    </span>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
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

    .result-card,
    .videos-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .result-card:hover,
    .videos-card:hover {
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
        align-items: center;
        gap: 10px;
    }

    .card-body {
        padding: 20px;
    }

    .result-table {
        margin: 0;
        border: none;
    }

    .result-table thead th {
        background: #234262;
        color: #fff;
        font-weight: 600;
        padding: 15px;
        border: none;
    }

    .result-table tbody td {
        padding: 15px;
        vertical-align: middle;
        border-color: #e0e0e0;
        color: #333;
    }

    .result-table tbody tr {
        transition: background 0.3s ease;
    }

    .result-table tbody tr:hover {
        background: #f9f9f9;
    }

    .correct {
        color: #28a745;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .wrong {
        color: #dc3545;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .result-table tfoot td {
        font-weight: 600;
        padding: 15px;
        background: #f4f6f9;
    }

    .result-table tfoot td:first-child {
        color: #234262;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .related-videos {
        margin-top: 50px;
    }

    .video-row {
        padding: 10px 0;
        border-bottom: 1px solid #e0e0e0;
        transition: background 0.3s ease;
    }

    .video-row:hover {
        background: #f9f9f9;
    }

    .video-row:last-child {
        border-bottom: none;
    }

    .video-title {
        margin: 0;
        font-size: 1rem;
        color: #333;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .video-title i {
        color: #234262;
    }

    .video-action {
        flex-shrink: 0;
    }

    .btn-success {
        background: #28a745;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        font-size: 0.95rem;
        transition: background 0.3s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .btn-success:hover {
        background: #218838;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header h2 {
            font-size: 1.5rem;
        }

        .card-header {
            font-size: 1.1rem;
        }

        .result-table th,
        .result-table td {
            padding: 10px;
            font-size: 0.95rem;
        }

        .video-title {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .main-page {
            padding: 10px;
        }

        .page-header {
            padding: 15px;
        }

        .result-table th,
        .result-table td {
            display: block;
            width: 100%;
            text-align: left;
            padding: 10px 15px;
            border: none;
            border-bottom: 1px solid #e0e0e0;
        }

        .result-table thead {
            display: none;
        }

        .result-table tbody td:before {
            content: attr(data-label);
            font-weight: bold;
            color: #234262;
            display: block;
            margin-bottom: 5px;
        }

        .result-table tbody td:nth-child(1):before {
            content: "Question No";
        }

        .result-table tbody td:nth-child(2):before {
            content: "Answer Status";
        }

        .result-table tfoot td {
            font-size: 0.9rem;
        }

        .video-title {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .btn-success {
            width: 100%;
            justify-content: center;
        }
    }
</style>