<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Terms and Conditions';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="terms-container container mt-5 mb-5">
    <h1 class="page-header">
        <i class="fas fa-file-contract"></i> <?= Html::encode($this->title) ?>
    </h1>

    <div class="terms-content card">
        <div class="card-body">
            <h2>Introduction</h2>
            <p>Welcome to our platform! By accessing or using our services, you agree to be bound by these Terms and Conditions. Please read them carefully.</p>

            <h2>1. Acceptance of Terms</h2>
            <p>By using this website, you signify your acceptance of these terms. If you do not agree, please do not use our services.</p>

            <h2>2. User Responsibilities</h2>
            <p>You are responsible for maintaining the confidentiality of your account and password. You agree to notify us immediately of any unauthorized use.</p>

            <h2>3. Content Usage</h2>
            <p>All content provided on this site (e.g., quizzes, lectures) is for personal use only. Redistribution or commercial use is prohibited without prior written consent.</p>

            <h2>4. Modifications</h2>
            <p>We reserve the right to modify these terms at any time. Changes will be effective upon posting on this page.</p>

            <h2>5. Contact Us</h2>
            <p>If you have any questions about these Terms and Conditions, please contact us at <a href="mailto:drcoachingacademy.com">drcoachingacademy.com</a>.</p>

            <div class="terms-footer">
                <p><em>Last Updated: March 26, 2025</em></p>
            </div>
        </div>
    </div>
</div>

<style>
    .terms-container {
        max-width: 800px;
        /* Limit width for readability */
        margin: 0 auto;
        /* Center the container */
        font-family: 'Poppins', sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, #234262, #2a5298);
        color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        font-size: 1.8rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .terms-content {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .terms-content h2 {
        color: #234262;
        font-size: 1.5rem;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .terms-content p {
        color: #333;
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .terms-content a {
        color: #2a5298;
        text-decoration: none;
    }

    .terms-content a:hover {
        text-decoration: underline;
    }

    .terms-footer {
        text-align: right;
        font-style: italic;
        color: #666;
        margin-top: 20px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            font-size: 1.5rem;
            padding: 15px;
        }

        .terms-content h2 {
            font-size: 1.3rem;
        }

        .terms-content p {
            font-size: 0.95rem;
        }
    }

    @media (max-width: 576px) {
        .terms-container {
            padding: 10px;
        }

        .page-header {
            font-size: 1.3rem;
            padding: 10px;
        }

        .terms-content {
            padding: 15px;
        }

        .terms-content h2 {
            font-size: 1.2rem;
        }

        .terms-content p {
            font-size: 0.9rem;
        }
    }
</style>

<?php
// Register Font Awesome for icons (if not already included in layout)
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', [
    'position' => \yii\web\View::POS_HEAD
]);
?>