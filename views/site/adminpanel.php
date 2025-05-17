<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="container mt-5">
    <h4 class="alert alert-success">Admin Dashboard</h4>
    <div class="row">
        <!-- Student Paid Section -->
        <div class="col-6 mb-4">
            <div class="card" style="height: 350px;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Active Students - Paid</h5>
                    <a href="<?= Url::to(['user/index', 'UserSearch[fee_paid]' => 'yes']) ?>" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body" style="max-height: 270px; overflow-y: auto;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['student_paid'] as $student): ?>
                                <tr>
                                    <td><?= Html::encode($student['full_name']) ?></td>
                                    <td><?= Html::encode($student['status']) ?></td>
                                    <td>
                                        <a href="<?= Url::to(['user/update', 'id' => $student['id']]) ?>" class="btn btn-sm btn-warning">Update</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Student Unpaid Section -->
        <div class="col-6 mb-4">
            <div class="card" style="height: 350px;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Active Students - Unpaid</h5>
                    <a href="<?= Url::to(['user/index', 'UserSearch[fee_paid]' => 'no']) ?>" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body" style="max-height: 270px; overflow-y: auto;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['student_unpaid'] as $student): ?>
                                <tr>
                                    <td><?= Html::encode($student['full_name']) ?></td>
                                    <td><?= Html::encode($student['status']) ?></td>
                                    <td>
                                        <a href="<?= Url::to(['user/update', 'id' => $student['id']]) ?>" class="btn btn-sm btn-warning">Update</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Inactive Students Section -->
        <div class="col-6 mb-4">
            <div class="card" style="height: 350px;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Inactive Students</h5>
                    <a href="<?= Url::to(['user/index', 'UserSearch[active]' => 'inactive']) ?>" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body" style="max-height: 270px; overflow-y: auto;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['student_inactive'] as $student): ?>
                                <tr>
                                    <td><?= Html::encode($student['full_name']) ?></td>
                                    <td><?= Html::encode($student['status']) ?></td>
                                    <td>
                                        <a href="<?= Url::to(['user/update', 'id' => $student['id']]) ?>" class="btn btn-sm btn-warning">Update</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sessions Section -->
        <div class="col-6 mb-4">
            <div class="card" style="height: 350px;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Active Sessions</h5>
                    <a href="<?= Url::to(['session/index']) ?>" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body" style="max-height: 270px; overflow-y: auto;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Session Name</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['sessions'] as $session): ?>
                                <tr>
                                    <td><?= Html::encode($session['name']) ?></td>
                                    <td><?= Html::encode($session['start_time']) ?></td>
                                    <td><?= Html::encode($session['end_time']) ?></td>
                                    <td>
                                        <a href="<?= Url::to(['session/update', 'id' => $session['id']]) ?>" class="btn btn-sm btn-warning">Update</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>