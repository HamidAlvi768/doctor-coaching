<?php

use app\models\Quiz;
use app\models\QuizSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\QuizSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Quizzes';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    /* Your existing pagination styles remain unchanged */
</style>

<div class="quiz-index container mt-5 mb-5">
    <h4 class="alert alert-success">Quizzes | Admin Dashboard</h4>

    <p>
        <?= Html::a('Create Quiz', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'sessionName',
                'label' => 'Session',
                'value' => function ($model) {
                    return $model->session->name ?? '';
                },
            ],
            'title',
            'description:ntext',
            'start_at',
            [
                'attribute' => 'isAttempted',
                'label' => 'Attempted',
                'format' => 'raw',
                'value' => function ($model) {
                    return QuizSearch::isQuizAttempted($model->id) ? "<a href=".Url::to(["quiz/results?id=$model->id"])." class='badge badge-success'>Results</a>" : '<span class="badge bg-danger">No</span>';
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'isAttempted',
                    ['' => 'All', '1' => 'Yes', '0' => 'No'],
                    ['class' => 'form-control']
                ),
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Quiz $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>