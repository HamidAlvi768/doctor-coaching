<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Session $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="card card-secondary">
    <div class="card-header">
        Session Form
    </div>
    <div class="card-body">
        <div class="session-form">

            <?php $form = ActiveForm::begin(); ?>

            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'name')->input('text', ['required' => true]) ?>
                </div>

                <div class="col-md-12">
                    <?= $form->field($model, 'description')->textarea(['required' => true]) ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'type')->dropDownList(
                        [
                            'demo' => 'Demo',    // Value => Display Text
                            'not_demo' => 'Not Demo',    // Empty Value => 'Not Demo'
                        ],
                        [
                            'prompt' => 'Select Type',
                            'required' => true,    // Make it required
                            'options' => [
                                'demo' => ['Selected' => $model->type == 'demo'],  // Select 'Demo' if it matches the value in DB
                                'not_demo' => ['Selected' => $model->type == 'not_demo'],          // Select 'Not Demo' if the value is empty
                            ],
                        ]
                    ) ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'start_time')->input('datetime-local', ['required' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'end_time')->input('datetime-local', ['required' => true]) ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>

<?php if (isset($allusers)) { ?>

    <div class="card card-primary mt-4">
        <div class="card-header">
            related tabs
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button onclick="
                        $('.relatedtabsbtns').removeClass('active');
                        $(this).addClass('active');
                        $('.relatedtabsection').removeClass('active');
                        $('.relatedtabsectionst').addClass('active');
                        $('.relatedtabsection').removeClass('show');
                        $('.relatedtabsectionst').addClass('show');
                        "
                        class="nav-link active relatedtabsbtns" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Students</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button onclick="$('.relatedtabsbtns').removeClass('active'); $(this).addClass('active');
                     $('.relatedtabsection').removeClass('active');
                        $('.relatedtabsectionqz').addClass('active');
                        $('.relatedtabsection').removeClass('show');
                        $('.relatedtabsectionqz').addClass('show');
                    " class="nav-link relatedtabsbtns" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Quizzes</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button onclick="$('.relatedtabsbtns').removeClass('active'); $(this).addClass('active');
                     $('.relatedtabsection').removeClass('active');
                        $('.relatedtabsectionlecture').addClass('active');
                        $('.relatedtabsection').removeClass('show');
                        $('.relatedtabsectionlecture').addClass('show');
                    " class="nav-link relatedtabsbtns" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Lectures</button>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane relatedtabsection relatedtabsectionst fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <?php Pjax::begin(); ?> <!-- Enable PJAX for seamless pagination -->

                    <?= GridView::widget([
                        'dataProvider' => $allusers, // Use the dataProvider from the search model
                        'filterModel' => $usermodel, // Enable filter inputs in the header
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'], // Serial numbers

                            [
                                'attribute' => 'username', // Use 'username' field
                                'label' => 'Email', // Change label to "Email"
                                'format' => 'raw', // Enable raw HTML output for the action buttons
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

                            'email_verified:datetime', // Display as datetime format
                            'status',
                            'fee_paid',
                            'created_at:datetime', // Display as datetime format
                        ],
                    ]); ?>



                    <?php Pjax::end(); ?>
                </div>
                <div class="tab-pane relatedtabsection relatedtabsectionqz fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Duration (minutes)</th>
                                <th>Start At</th>
                                <th>End At</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allquizz as $index => $quiz): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td> <!-- Serial number -->
                                    <td><?= Html::encode($quiz['title']) ?></td>
                                    <td><?= Html::encode($quiz['duration_in_minutes']) ?></td>
                                    <td><?= Html::encode($quiz['start_at']) ?></td> <!-- Adjust formatting if needed -->
                                    <td><?= Html::encode($quiz['end_at']) ?></td> <!-- Adjust formatting if needed -->
                                    <td><?= Html::encode($quiz['status']) ?></td>
                                    <td><?= Html::encode($quiz['created_at']) ?></td> <!-- Adjust formatting if needed -->
                                    <td>
                                        <?= Html::a('Edit', ['quiz/update', 'id' => $quiz['id']], ['class' => 'btn btn-success btn-sm']) ?>
                                        <?= Html::a('Delete', ['quiz/delete', 'id' => $quiz['id']], [
                                            'class' => 'btn btn-danger btn-sm',
                                            'data-confirm' => 'Are you sure you want to delete this quiz?',
                                            'data-method' => 'post',
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane relatedtabsection relatedtabsectionlecture fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>

                                <th>Title</th>
                                <th>description</th>
                                <th>Video</th>
                                <th>Uploaded at</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($videos as $v): ?>
                                <tr>

                                    <td><?= Html::encode($v['title']) ?></td>
                                    <td><?= Html::encode($v['description']) ?></td>
                                    <td><?= Html::encode($v['file_path']) ?></td> <!-- Adjust formatting if needed -->
                                    <td><?= Html::encode($v['created_at']) ?></td> <!-- Adjust formatting if needed -->

                                    <td>
                                        <?= Html::a('Edit', ['session/lectureupdate', 'id' => $v['id']], ['class' => 'btn btn-success btn-sm']) ?>
                                        <?= Html::a('Delete', ['session/lecturedelete', 'id' => $v['id']], [
                                            'class' => 'btn btn-danger btn-sm',
                                            'data-confirm' => 'Are you sure you want to delete this quiz?',
                                            'data-method' => 'post',
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } ?>