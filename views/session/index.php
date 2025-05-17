<?php

use app\models\Session;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\SessionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Sessions';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    /* Pagination container */
    ul.pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin: 20px 0;
        font-size: 16px;
    }

    /* Pagination items */
    ul.pagination li {
        margin: 0 5px;
    }

    /* Disabled button */
    ul.pagination li.disabled span {
        color: #999;
        cursor: not-allowed;
    }

    /* Active page */
    ul.pagination li.active a {
        color: white;
        background-color: #234262;
        border-color: #234262;
        padding: 8px 12px;
        border-radius: 4px;
        text-decoration: none;
    }

    /* Regular pagination links */
    ul.pagination li a {
        color: #234262;
        padding: 8px 12px;
        text-decoration: none;
        border-radius: 4px;
        border: 1px solid #234262;
        transition: background-color 0.3s, color 0.3s;
    }

    /* Hover effect */
    ul.pagination li a:hover {
        background-color: #234262;
        color: white;
        text-decoration: none;
    }

    /* Responsive styling */
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

<div class="session-index container mt-5 mb-5">

    <h4 class="alert alert-success">Sessions | Admin Dashboard</h4>

    <p>
        <?= Html::a('Create Session', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Create Quiz', ['quiz/create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Create Lecture', ['session/lecture'], ['class' => 'btn btn-success']) ?>
    </p>


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',

            'start_time',
            'end_time',
            'created_at',
            'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Session $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>