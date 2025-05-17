<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var array $results */
/** @var int $quiz_id */
/** @var int $totalQuestions */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Quiz Results';
$this->params['breadcrumbs'][] = ['label' => 'Quizzes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    ul.pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin: 20px 0;
        font-size: 16px;
    }

    ul.pagination li {
        margin: 0 5px;
    }

    ul.pagination li.disabled span {
        color: #999;
        cursor: not-allowed;
    }

    ul.pagination li.active a {
        color: white;
        background-color: #234262;
        border-color: #234262;
        padding: 8px 12px;
        border-radius: 4px;
        text-decoration: none;
    }

    ul.pagination li a {
        color: #234262;
        padding: 8px 12px;
        text-decoration: none;
        border-radius: 4px;
        border: 1px solid #234262;
        transition: background-color 0.3s, color 0.3s;
    }

    ul.pagination li a:hover {
        background-color: #234262;
        color: white;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        ul.pagination {
            font-size: 14px;
        }

        ul.pagination li a,
        ul.pagination li.active a {
            padding: 6px 10px;
        }
    }

    @media (max-width: 576px) {
        ul.pagination {
            font-size: 12px;
        }

        ul.pagination li a,
        ul.pagination li.active a {
            padding: 5px 8px;
        }
    }
</style>

<div class="quiz-index container mt-5 mb-5">
    <h4 class="alert alert-success">Results | Admin Dashboard</h4>

    <!-- Display flash messages -->
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Html::encode(Yii::$app->session->getFlash('error')) ?>
        </div>
    <?php endif; ?>

    <p style="display: flex; justify-content: right;">
        <?= Html::a('Back', Yii::$app->request->referrer ?: ['index'], ['class' => 'btn btn-warning']) ?>
    </p>

    <?php // Pjax::begin(); ?>

    <div class="container">
        <div class="table-responsive">
            <?php if (empty($results)): ?>
                <div class="alert alert-info">No students have attempted this quiz yet.</div>
            <?php else: ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sr#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Correct Answers</th>
                            <th>Incorrect Answers</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $page = $dataProvider->pagination->page; // Current page (0-based)
                        $pageSize = $dataProvider->pagination->pageSize; // Items per page
                        $sr = $page * $pageSize; // Starting serial number
                        foreach ($results as $result):
                            $sr++;
                            $student = $result['student'];
                            $correct = $result['correct'];
                            $incorrect = $result['incorrect'];
                        ?>
                            <tr>
                                <th><?= $sr ?></th>
                                <td><?= Html::encode($student->full_name ?? 'N/A') ?></td>
                                <td><?= Html::encode($student->email ?? 'N/A') ?></td>
                                <td><?= Html::encode($correct) ?></td>
                                <td><?= Html::encode($incorrect) ?></td>
                                <th><?= Html::encode($totalQuestions) ?></th>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <!-- Pagination (only if there are results) -->
        <?php if (!empty($results)): ?>
            <div class="pagination-container">
                <?= LinkPager::widget([
                    'pagination' => $dataProvider->pagination,
                    'options' => ['class' => 'pagination'],
                    'linkOptions' => ['class' => 'page-link'],
                    'activePageCssClass' => 'active',
                    'disabledPageCssClass' => 'disabled',
                ]) ?>
            </div>
        <?php endif; ?>
    </div>

    <?php //Pjax::end(); ?>
</div>