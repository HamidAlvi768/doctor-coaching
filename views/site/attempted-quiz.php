<?php
use yii\helpers\Html;

$this->title = 'Attempted Quizzes';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="main-page">
    <div class="page-header">
        <h2><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="page-content">
        <?php if (empty($quizData)): ?>
            <div class="card profile-card">
                <div class="card-body">
                    <p>No quizzes attempted yet.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($quizData as $quizId => $data): ?>
                <div class="card quiz-card mt-5">
                    <div class="card-header">
                        <?= Html::encode($data['quiz']['title']) ?>
                    </div>
                    <div class="card-body">
                        <div class="quiz-details">
                            <p><strong>Description:</strong> <?= Html::encode($data['quiz']['description'] ?: 'No description available') ?></p>
                            <p><strong>Session:</strong> <?= Html::encode($data['session']['name']) ?></p>
                            <p><strong>Duration:</strong> <?= Html::encode($data['quiz']['duration_in_minutes']) ?> minutes</p>
                            <p><strong>Start:</strong> <?= Html::encode($data['quiz']['start_at']) ?></p>
                            <p><strong>End:</strong> <?= Html::encode($data['quiz']['end_at']) ?></p>
                        </div>

                        <div class="questions-section mt-4">
                            <h3>Questions & Responses</h3>
                            <?php foreach ($data['questions'] as $question): ?>
                                <div class="question-block">
                                    <p><strong>Q<?= Html::encode($question['qnumber']) ?>:</strong> <?= Html::encode($question['question_text']) ?> <span class="question-type">(<?= Html::encode($question['type']) ?>)</span></p>
                                    <?php if ($question['type'] === 'mcq'): ?>
                                        <ul class="answer-options">
                                            <?php foreach ($question['answers'] as $key=>$answer): ?>
                                                <li class="<?= $answer['is_correct'] ? 'correct-answer' : '' ?>">
                                                    <?php if($key==0){echo 'A.';}else if($key==1){echo 'B.';}else if($key==2){echo 'C.';}else if($key==3){echo 'D.';} ?>. <?= Html::encode($answer['answer_text']) ?> <?= $answer['is_correct'] ? '<i class="fas fa-check"></i>' : '' ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                    <p><strong>Your Answer:</strong>
                                        <span class="student-answer <?= $question['response']['is_correct'] ? 'correct' : 'incorrect' ?>">
                                            <?= Html::encode($question['response']['student_answer'] ?? 'Not answered') ?>
                                        </span>
                                    </p>
                                    <p><strong>Correct Answer:</strong> <?= Html::encode($question['response']['correct_answer']) ?></p>
                                    <p><strong>Submitted At:</strong> <?= Html::encode($question['response']['submitted_at'] ?? 'Not submitted') ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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
    }

    .page-content {
        width: 100%;
    }

    .quiz-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .quiz-card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        background: #234262;
        color: #fff;
        padding: 15px;
        border-radius: 10px 10px 0 0;
        font-size: 1.2rem;
        font-weight: 600;
    }

    .card-body {
        padding: 25px;
    }

    .quiz-details p {
        color: #234262;
        font-size: 1rem;
        margin-bottom: 10px;
        font-weight: 500;
    }

    .quiz-details p strong {
        color: #2a5298;
    }

    .questions-section h3 {
        color: #234262;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .question-block {
        background: #f9f9f9;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .question-block p {
        margin: 5px 0;
        color: #333;
        font-size: 0.95rem;
    }

    .question-block p strong {
        color: #234262;
        font-weight: 600;
    }

    .question-type {
        font-size: 0.85rem;
        color: #666;
        font-style: italic;
    }

    .answer-options {
        list-style: none;
        padding: 0;
        margin: 10px 0 10px 20px;
    }

    .answer-options li {
        font-size: 0.9rem;
        color: #333;
        margin-bottom: 5px;
    }

    .correct-answer {
        color: #28a745;
        font-weight: 500;
    }

    .correct-answer i {
        margin-left: 5px;
    }

    .student-answer.correct {
        color: #28a745;
        font-weight: 500;
    }

    .student-answer.incorrect {
        color: #dc3545;
        font-weight: 500;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header h2 {
            font-size: 1.5rem;
        }

        .card-body {
            padding: 20px;
        }

        .questions-section h3 {
            font-size: 1.2rem;
        }

        .question-block {
            padding: 10px;
        }

        .answer-options {
            margin-left: 10px;
        }
    }

    @media (max-width: 576px) {
        .main-page {
            padding: 10px;
        }

        .page-header {
            padding: 15px;
        }

        .quiz-details p {
            font-size: 0.9rem;
        }

        .question-block p {
            font-size: 0.85rem;
        }

        .card-header {
            font-size: 1rem;
        }
    }
</style>

<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">