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

$this->title = 'Videos/Lectures';
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

    <h4 class="alert alert-success">Lectures/Videos | Admin Dashboard</h4>
    <p>
        <?= Html::a('Create Lecture', ['session/lecture'], ['class' => 'btn btn-success']) ?>

    </p>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'allModels' => $video, // $video is passed from the controller
            'pagination' => [
                'pageSize' => 100,
            ],
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], // Serial column (auto-incrementing number)
            [
                'label' => 'Quiz',
                'value' => function ($model) {
                    return $model->quiz->title ?? "";
                }
            ],
            'title', // Example: Video title (assuming your Video model has a 'title' attribute)
            'description', // Example: Video description

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}', // Defines which buttons to show
                'buttons' => [
                    'update' => function ($url, $model) {
                        // Create the update button with custom URL (session/lectureupdate?id=)
                        return Html::a('Update', ['session/lectureupdate', 'id' => $model->id], [
                            'class' => 'btn btn-primary btn-sm',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        // Create the delete button with custom URL (session/deletevideo?id=)
                        return Html::a('Delete', ['session/lecturedelete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'method' => 'post', // Use POST method for deletion
                                'confirm' => 'Are you sure you want to delete this video?',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>