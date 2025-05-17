<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Re Attempts Requests';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="news-index container mt-5 mb-5">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th> <!-- Serial Number Column -->
                    <th>Student</th>
                    <th>Sessions</th>
                    <th>Quiz</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $models = $dataProvider->getModels();
                $serialNumber = ($dataProvider->pagination->page * $dataProvider->pagination->pageSize) + 1; // Starting serial number
                foreach ($models as $model):
                ?>
                   <?php if($model->student && $model->quiz && $model->reason):?>
                    <tr>
                        <td><?= $serialNumber++ ?></td> <!-- Incrementing serial number -->
                        <td><?= Html::encode($model->student->username) ?></td>
                        <td><?= $model->quiz->session->name??"" ?></td>
                        <td><?= Html::encode($model->quiz->title) ?></td>
                        <td><?= Html::encode($model->reason) ?></td>
                        <td>
                            <span class="badge <?= Html::encode($model->status) == 0 ? 'badge-success' : 'badge-danger' ?>">
                                <?= Html::encode($model->status) == 0 ? 'Pending' : 'Approved' ?>
                            </span>
                        </td>
                        <td>
                            <?php if (Html::encode($model->status) == 0): ?>
                                <?= Html::a('Approve', ['approve-request', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endif;?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Controls -->
    <?= LinkPager::widget([
        'pagination' => $dataProvider->pagination,
        'options' => ['class' => 'pagination justify-content-center'], // Center the pagination
        'linkOptions' => ['class' => 'page-link'],
        'disabledPageCssClass' => 'page-item disabled',
        'activePageCssClass' => 'page-item active',
    ]) ?>
</div>