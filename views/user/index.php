<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $usermodel app\models\UserSearch */ // Update to use UserSearch
/* @var $allusers yii\data\ActiveDataProvider */ // Update to use ActiveDataProvider

$this->title = 'View all Users';
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
<div class="container mt-5 mb-5 user-update">

    <h4 class="alert alert-success"><?= Html::encode($this->title) ?></h4>

    <?php Pjax::begin(); ?> <!-- Enable PJAX for seamless pagination -->

    <?= GridView::widget([
        'dataProvider' => $allusers, // Use the dataProvider from the search model
        'filterModel' => $usermodel, // Enable filter inputs in the header
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], // Serial numbers

            [
                'attribute' => 'username',
                'label' => 'Email', // Change label to "Email"
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->username . '<br>' .
                        Html::a('<span style="color:green;" class="">edit</span>', ['user/update', 'id' => $model->id], ['title' => 'Update']) . ' | ' .
                        Html::a('<span style="color:red;" class="">delete</span>', ['user/delete', 'id' => $model->id], [
                            'title' => 'Delete',
                            'data-confirm' => 'Are you sure you want to delete this user?',
                            'data-method' => 'post',
                        ]);
                }
            ],
            [
                'label' => 'User Type',
                'attribute' => 'usertype',
                'format' => 'raw',
                'filter' => [
                    '' => 'All',       // Show "All" option to show all users
                    'student' => 'Studetn',
                    'admin' => 'Admin',
                ],
                'value' => function ($model) {
                    return $model->usertype;
                }
            ],
            'email_verified:datetime', // Display as datetime format
            [
                'label' => 'Status',
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => [
                    '' => 'All',       // Show "All" option to show all users
                    'inactive' => 'Inactive',
                    'active' => 'Active',
                ],
                'value' => function ($model) {
                    return $model->status;
                }
            ],
            [
                'label' => 'Fee Paid',
                'attribute' => 'fee_paid',
                'format' => 'raw',
                'filter' => [
                    '' => 'All',       // Show "All" option to show all users
                    'no' => 'No',
                    'yes' => 'Yes',
                ],
                'value' => function ($model) {
                    return $model->fee_paid;
                }
            ],
            [
                'label' => 'Active Session',
                'format' => 'raw', // Use 'raw' format to render HTML content
                'value' => function ($model) {
                    if ($model->session_id == "") {
                        return '<span class="badge badge-danger">No Logged</span>';
                    } else {
                        return '<a href="' . \yii\helpers\Url::to(['user/force-logout', 'id' => $model->id]) .
                            '" class="btn btn-sm btn-success" onclick="return confirm(\'Are you sure you want to force logout this user?\')">Logged <small>(Logout)</small></a>';
                    }
                }
            ],
            'login_time',
            'created_at:datetime', // Display as datetime format
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>