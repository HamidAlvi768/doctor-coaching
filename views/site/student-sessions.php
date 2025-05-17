<?php
/** @var yii\web\View $this */
/** @var array $assignedSessions */
/** @var array $sessions */

use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Student Sessions';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css', ['position' => \yii\web\View::POS_HEAD]);
?>

<div class="main-page">
    <div class="page-header">
        <h2><i class="fas fa-calendar-alt"></i> <?= Html::encode($this->title) ?></h2>
    </div>
    <div class="page-content">
        <!-- Assigned Sessions -->
        <div class="sessions-container">
            <h3 class="section-title"><i class="fas fa-check-circle"></i> Assigned Sessions</h3>
            <?php if (empty($assignedSessions)): ?>
                <p class="no-data">No assigned sessions available.</p>
            <?php else: ?>
                <div class="sessions-list">
                    <?php foreach ($assignedSessions as $key => $session): ?>
                        <div class="session-card">
                            <div class="session-card-header">
                                <span class="session-number"><?= $key + 1 ?></span>
                                <h4 class="session-title">
                                    <?= Html::a('<i class="fas fa-link"></i> ' . Html::encode($session->name), ['site/quizlist', 'id' => $session->id], [
                                        'class' => 'session-link',
                                    ]); ?>
                                </h4>
                            </div>
                            <div class="session-card-body">
                                <p class="session-date">
                                    <i class="fas fa-calendar"></i> 
                                    <?= date('d M Y', strtotime($session->start_time)) . ' - ' . date('d M Y', strtotime($session->end_time)) ?>
                                </p>
                                <p class="session-fees">
                                    <i class="fas fa-money-bill-wave"></i> 
                                    <?php
                                    $isPaid = $session->type == "demo" ? true : false; // Adjust based on your model
                                    ?>
                                    <span class="fee-status <?= $isPaid ? 'paid' : 'not-paid' ?>">
                                        <?= $isPaid ? 'Paid' : 'Not Paid' ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Other Sessions (Unassigned) -->
        <div class="sessions-container mt-4">
            <h3 class="section-title"><i class="fas fa-list"></i> Other Sessions</h3>
            <?php
            $assignedSessionIds = array_column($assignedSessions, 'id');
            $unassignedSessions = array_filter($sessions, function ($session) use ($assignedSessionIds) {
                return !in_array($session->id, $assignedSessionIds);
            });
            ?>
            <?php if (empty($unassignedSessions)): ?>
                <p class="no-data">No other sessions available.</p>
            <?php else: ?>
                <div class="sessions-list">
                    <?php $sr = 0; foreach ($unassignedSessions as $key => $session): $sr++; ?>
                        <div class="session-card">
                            <div class="session-card-header">
                                <span class="session-number"><?= $sr ?></span>
                                <h4 class="session-title">
                                    <?= Html::a('<i class="fas fa-link"></i> ' . Html::encode($session->name), ['site/quizlist', 'id' => $session->id], [
                                        'class' => 'session-link',
                                    ]); ?>
                                </h4>
                            </div>
                            <div class="session-card-body">
                                <p class="session-date">
                                    <i class="fas fa-calendar"></i> 
                                    <?= date('d M Y', strtotime($session->start_time)) . ' - ' . date('d M Y', strtotime($session->end_time)) ?>
                                </p>
                                <p class="session-fees">
                                    <i class="fas fa-money-bill-wave"></i> 
                                    <?php if (Yii::$app->user->identity->fee_paid == 0): ?>
                                        <?php $isPaid = isset($session->is_paid) ? $session->is_paid : false; ?>
                                        <span class="fee-status <?= $isPaid ? 'paid' : 'not-paid' ?>">
                                            <?= $isPaid ? 'Paid' : 'Not Paid' ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="fee-status">Not Assigned</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
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

    .sessions-container {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
        transition: transform 0.3s ease;
    }

    .sessions-container:hover {
        transform: translateY(-5px);
    }

    .section-title {
        font-size: 1.4rem;
        color: #234262;
        margin-bottom: 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .no-data {
        color: #666;
        font-style: italic;
        text-align: center;
        padding: 20px;
    }

    /* Desktop Table Layout */
    @media (min-width: 769px) {
        .sessions-list {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .session-card {
            display: table-row;
        }

        .session-card-header,
        .session-card-body {
            display: table-cell;
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #e0e0e0;
        }

        .session-card-header {
            width: 40%;
        }

        .session-card-body {
            width: 60%;
        }

        .session-number {
            display: inline-block;
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            background: #234262;
            color: #fff;
            border-radius: 50%;
            margin-right: 10px;
            font-size: 0.9rem;
        }

        .session-title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 500;
            display: inline;
        }

        .session-date,
        .session-fees {
            margin: 5px 0;
            font-size: 0.95rem;
            color: #333;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sessions-list .session-card:hover {
            background: #f9f9f9;
        }
    }

    /* Mobile Card Layout */
    @media (max-width: 768px) {
        .sessions-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .session-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .session-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .session-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .session-number {
            width: 35px;
            height: 35px;
            line-height: 35px;
            text-align: center;
            background: #234262;
            color: #fff;
            border-radius: 50%;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .session-title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 500;
            color: #234262;
            flex-grow: 1;
        }

        .session-card-body {
            padding-left: 45px; /* Align with title text */
        }

        .session-date,
        .session-fees {
            margin: 8px 0;
            font-size: 0.95rem;
            color: #333;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    }

    .session-link {
        color: #234262;
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border-radius: 5px;
        transition: background 0.2s ease;
    }

    .session-link:hover {
        color: #2a5298;
        background: #e8eef5;
        text-decoration: none;
    }

    .fee-status {
        font-weight: 500;
        padding: 5px 10px;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .fee-status.paid {
        background: #d4edda;
        color: #155724;
    }

    .fee-status.not-paid {
        background: #f8d7da;
        color: #721c24;
    }

    /* General Responsive Adjustments */
    @media (max-width: 576px) {
        .main-page {
            padding: 15px;
        }

        .page-header {
            padding: 15px;
        }

        .page-header h2 {
            font-size: 1.5rem;
        }

        .section-title {
            font-size: 1.2rem;
        }

        .session-card {
            padding: 12px;
        }

        .session-number {
            width: 30px;
            height: 30px;
            line-height: 30px;
            font-size: 0.9rem;
        }

        .session-title {
            font-size: 1rem;
        }

        .session-date,
        .session-fees {
            font-size: 0.9rem;
        }

        .session-link {
            padding: 8px;
            font-size: 0.95rem;
        }
    }
</style>