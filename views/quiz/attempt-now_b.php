<?php

/** @var yii\web\View $this */
/** @var app\models\Quiz $quiz */
/** @var app\models\QuizTime $quizTime */

use yii\bootstrap5\Html;

$this->title = 'Quizzes List';
$this->params['breadcrumbs'][] = $this->title;

// Register Font Awesome CDN
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css', ['position' => \yii\web\View::POS_HEAD]);
?>

<div class="quiz-container">
    <div id="answermodalparent" class="modal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-question-circle"></i> Question <span id="qnumber"></span>
                    </h5>
                    <span id="timer" class="timer"></span>
                </div>
                <div class="modal-body" id="answermodal">
                    <p id="qtext" class="question-text">Question text here</p>
                    <section id="multipleanswer" style="display:none;">
                        <div class="options-grid">
                            <button id="optiona" datai="" datat="" class="option-btn">Option A</button>
                            <button id="optionb" datai="" datat="" class="option-btn">Option B</button>
                            <button id="optionc" datai="" datat="" class="option-btn">Option C</button>
                            <button id="optiond" datai="" datat="" class="option-btn">Option D</button>
                        </div>
                        <div class="feedback" id="mcq-feedback"></div>
                    </section>
                    <section id="truefalseanswer" style="display:none;">
                        <label>Select your answer:</label>
                        <select class="form-control" id="truefalsedropdown">
                            <option value="true">True</option>
                            <option value="false">False</option>
                        </select>
                        <div class="feedback" id="tf-feedback"></div>
                    </section>
                    <section id="textanswer" style="display:none;">
                        <label>Enter your answer:</label>
                        <textarea class="form-control" rows="3" id="textanswerinput"></textarea>
                        <div class="feedback" id="text-feedback"></div>
                    </section>
                </div>
                <div class="modal-background"></div>
                <div class="email-overlay">Logged in as: <?= Yii::$app->user->identity->email ?></div>
                <div class="modal-footer">
                    <div class="left-btns">
                        <button onclick="closeQuiz()" type="button" id="close-btn" class="btn btn-close-modal">Close</button>
                        <button onclick="goBack()" type="button" id="previous-btn" class="btn btn-previous" style="display: none;">Previous</button>
                    </div>
                    <div class="right-btns">
                        <button onclick="skip()" type="button" id="skip-btn" class="btn btn-skip">Skip</button>
                        <button onclick="goNext()" type="button" id="next-btn" class="btn btn-next" style="display: none;">Next</button>
                        <button onclick="submitAnswer()" type="button" id="submit-btn" class="btn btn-submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background: #1a1a2e;
        font-family: 'Poppins', sans-serif;
        color: #e0e0e0;
    }

    .quiz-container {
        padding: 20px;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal {
        display: none;
        background: rgba(0, 0, 0, 0.8);
    }

    .modal.show {
        display: block;
    }

    .modal-dialog.modal-fullscreen {
        width: 100%;
        max-width: none;
        margin: 0;
    }

    .modal-content {
        background: linear-gradient(135deg, #16213e, #0f3460);
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        height: 100vh;
        position: relative;
        overflow: hidden;
        z-index: 2;
    }

    .modal-header {
        background: #0f3460;
        border-bottom: none;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .timer {
        background: #e94560;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 1rem;
        font-weight: 500;
        color: #fff;
    }

    .modal-body {
        padding: 40px;
        text-align: center;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .question-text {
        font-size: 1.8rem;
        color: #fff;
        margin-bottom: 30px;
        user-select: none;
        text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }

    .options-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }

    .option-btn {
        background: #e0e0e0;
        color: #1a1a2e;
        border: none;
        padding: 15px;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: transform 0.2s ease, background 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .option-btn:hover {
        transform: scale(1.05);
        background: #fff;
    }

    .option-btn.selected {
        background: #00d4ff;
        color: #fff;
    }

    .form-control {
        background: #fff;
        border: 1px solid #e94560;
        border-radius: 10px;
        padding: 10px;
        font-size: 1rem;
        color: #1a1a2e;
    }

    .form-control:focus {
        border-color: #00d4ff;
        box-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
    }

    label {
        color: #e0e0e0;
        font-weight: 500;
        margin-bottom: 10px;
        display: block;
    }

    .feedback {
        font-size: 1.2rem;
        font-weight: 600;
        margin-top: 20px;
        display: none;
    }

    .feedback.correct {
        color: #00cc00;
        animation: flash 0.5s ease;
        display: block;
    }

    .feedback.wrong {
        color: #ff3333;
        animation: shake 0.5s ease;
        display: block;
    }

    @keyframes flash {
        0% {
            opacity: 0;
            transform: scale(0.8);
        }

        50% {
            opacity: 1;
            transform: scale(1.1);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes shake {
        0% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-10px);
        }

        50% {
            transform: translateX(10px);
        }

        75% {
            transform: translateX(-10px);
        }

        100% {
            transform: translateX(0);
        }
    }

    .modal-background {
        background-image: url('../img/logo.png');
        background-size: 30%;
        background-position: center;
        background-repeat: no-repeat;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 0.1;
        z-index: 1;
        height: calc(100% - 60px);
        pointer-events: none;
    }

    .email-overlay {
        color: #e94560;
        font-weight: 600;
        opacity: 0.6;
        text-align: center;
        height: 60px;
        line-height: 60px;
        background: rgba(255, 255, 255, 0.1);
        position: absolute;
        bottom: 60px;
        width: 100%;
        z-index: 2;
    }

    .modal-footer {
        background: #0f3460;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        border-top: none;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 25px;
        font-size: 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-close-modal {
        background: #6c757d;
        color: #fff;
    }

    .btn-close-modal:hover {
        background: #5a6268;
    }

    .btn-previous {
        background: #00d4ff;
        color: #1a1a2e;
    }

    .btn-previous:hover {
        background: #00b3cc;
    }

    .btn-skip {
        background: #e94560;
        color: #fff;
    }

    .btn-skip:hover {
        background: #d43f52;
    }

    .btn-next,
    .btn-submit {
        background: #00cc00;
        color: #fff;
    }

    .btn-next:hover,
    .btn-submit:hover {
        background: #00a300;
    }

    @media (max-width: 768px) {
        .modal-body {
            padding: 20px;
        }

        .question-text {
            font-size: 1.5rem;
        }

        .options-grid {
            grid-template-columns: 1fr;
        }

        .modal-title {
            font-size: 1.2rem;
        }

        .timer {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .quiz-container {
            padding: 10px;
        }

        .modal-header {
            padding: 15px;
        }

        .modal-footer {
            flex-direction: column;
            gap: 10px;
        }

        .btn {
            width: 100%;
        }

        .modal-background {
            background-size: 70%;
        }
    }
</style>

<?php
$url = \yii\helpers\Url::to(['quiz/attempt']);
$url2 = \yii\helpers\Url::to(['question/attempt']);
$url3 = \yii\helpers\Url::to(['question/submitanswer']);
$getQuestionUrl = \yii\helpers\Url::to(['question/get']);
$submitQuestionUrl = \yii\helpers\Url::to(['question/q-submit-answer']);
$result_url= \yii\helpers\Url::to(['quiz/result?id='.$quiz->id]);
$timeLogUrl = \yii\helpers\Url::to(['quiz/time-log']);
$quizList = Yii::$app->request->referrer;
$session = Yii::$app->request->get('session');
$totalQuestions = count($quiz->getQuestions()->all());
$totalTimeInMinutes = $quiz->duration_in_minutes;
$spendTime = $quizTime->spend_time;
$start_time = $quizTime->start_time;
$log_time = $quizTime->log_time;

$this->registerJs("
    var quizList = '{$quizList}';
    var url = '{$url}';
    var url2 = '{$url2}';
    var url3 = '{$url3}';
    var result_rul= '{$result_url}';
    var getQuestionUrl = '{$getQuestionUrl}';
    var submitQuestionUrl = '{$submitQuestionUrl}';
    var timeLogUrl = '{$timeLogUrl}';
    var session = '{$session}';
    var csrfToken = $('meta[name=\"csrf-token\"]').attr('content');
    var id = {$quiz->id};
    var rid = null;
    var qn = 1;
    var totalQuestions = {$totalQuestions};
    var totalTimeInMinutes = {$totalTimeInMinutes};
    var startTime = '{$start_time}';
    var logTime = '{$log_time}';
    var currentSpendTime = 0;
    var spendTime = parseInt(getTimeDifferenceInSec(startTime));
    var selectedAnswer = null;

    function getTimeDifferenceInSec(st) {
        const givenTime = new Date(st);
        const currentTime = new Date();
        const diffMilliseconds = currentTime - givenTime;
        return Math.floor(diffMilliseconds / 1000);
    }

    var time = (totalTimeInMinutes * 60) - spendTime;
    console.log(time, spendTime);
    if (time > 0) {
        let timer = setInterval(() => {
            time--;
            currentSpendTime++;
            if (time >= 0) {
                let minutes = Math.floor(time / 60);
                let seconds = time % 60;
                seconds = seconds < 10 ? '0' + seconds : seconds;
                document.querySelector('#timer').textContent = minutes + ':' + seconds;
            } else {
                clearInterval(timer);
                document.querySelector('#timer').textContent = 'Time is up!';
                $('#submit-btn').hide();
                $('#skip-btn').hide();
            }
        }, 1000);

        let logTimer = setInterval(() => {
            if (time >= 0) {
                $.post(timeLogUrl, { id: id, _csrf: csrfToken, time: currentSpendTime }, function(response) {
                    console.log('Log Time');
                }).fail(function() {
                    console.log('Failed to send request.');
                });
                currentSpendTime = 0;
            } else {
                clearInterval(logTimer);
            }
        }, 5000);
    } else {
        document.querySelector('#timer').textContent = 'Time is up!';
        $('#submit-btn').hide();
        $('#skip-btn').hide();
    }

    $('#answermodalparent').addClass('show');
    showQuestion(id, qn);

    function showQuestion(id, qn) {
        fetch(getQuestionUrl + '?quiz-id=' + id + '&qnumber=' + qn)
            .then(response => response.json())
            .then(data => {
                getquestion(data);
            });
    }

    function skip() {
        qn++;
        $('#previous-btn').show();
        if (qn == totalQuestions) {
            $('#skip-btn').hide();
            $('#next-btn').hide();
        }
        if (qn <= totalQuestions) {
            showQuestion(id, qn);
        }
    }

    function goNext() {
        qn++;
        $('#previous-btn').show();
        if (qn == totalQuestions) {
            $('#skip-btn').hide();
            $('#next-btn').hide();
        }
        if (qn <= totalQuestions) {
            showQuestion(id, qn);
        }
    }

    function goBack() {
        qn--;
        showQuestion(id, qn);
        if (qn == 1) {
            $('#previous-btn').hide();
        }
    }

    function closeQuiz() {
        if (confirm('Want to close this quiz?')) {
            window.location.href = quizList;
        }
    }

    function submitAnswer() {
        let answerValue;
        const questionType = $('#answermodal').find('section:visible').attr('id');
        let feedbackEl;

        if (questionType === 'multipleanswer') {
            if (!selectedAnswer) {
                alert('Please select an option!');
                return;
            }
            answerValue = selectedAnswer;
            feedbackEl = $('#mcq-feedback');
        } else if (questionType === 'truefalseanswer') {
            answerValue = $('#truefalsedropdown').val();
            feedbackEl = $('#tf-feedback');
        } else if (questionType === 'textanswer') {
            answerValue = $('#textanswerinput').val();
            feedbackEl = $('#text-feedback');
        }

        console.log(answerValue);
        $.post(submitQuestionUrl, { 
            id: id, 
            _csrf: csrfToken, 
            qnumber: qn, 
            answer: answerValue, 
            session: session 
        }, function(response) {
            if (response.success) {
                const isCorrect = response.data.result === 'Correct';
                feedbackEl.html(isCorrect ? '<i class=\"fas fa-check\"></i> Correct!' : '<i class=\"fas fa-times\"></i> Incorrect!');
                feedbackEl.removeClass('correct wrong').addClass(isCorrect ? 'correct' : 'wrong');
                feedbackEl.show();
                $('#submit-btn').hide();
                $('#skip-btn').hide();
                $('#next-btn').show();
                if(qn == totalQuestions) {
                    $('#skip-btn').hide();
                    $('#next-btn').hide();
                    window.location.href = result_rul;
                }
            } else {
                alert('Error: ' + response.message);
            }
        }).fail(function() {
            console.log('Failed to send request.');
        });
    }

    function getquestion(response) {
        $('#truefalsedropdown').val('');
        $('#textanswerinput').val('');
        $('#mcq-feedback, #tf-feedback, #text-feedback').hide();
        $('.option-btn').removeClass('selected');
        selectedAnswer = null;

        if (response.success) {
            rid = response.data.rid;
            $('#qnumber').text(qn);
            $('#answermodal #qtext').text(response.data.question.question_text);
            var questionType = response.data.question.type;

            $('#multipleanswer, #truefalseanswer, #textanswer').hide();

            if (questionType === 'mcq') {
                $('#multipleanswer').show();
                var answers = response.data.answers;
                var options = ['a', 'b', 'c', 'd'];
                for (var i = 0; i < answers.length; i++) {
                    var t = options[i];
                    if (options[i]) {
                        $('#option' + t).text(t.toUpperCase() + ') ' + answers[i].answer_text);
                        $('#option' + t).attr('datat', answers[i].answer_text);
                        $('#option' + t).attr('datai', answers[i].id);
                    }
                }
                const qAnswer = response.data.attempted;
                if (qAnswer) {
                    $('#skip-btn').hide();
                    $('#submit-btn').hide();
                    $('#next-btn').show();
                    console.log(response.data.result);
                    $('#mcq-feedback').html(response.data.result === 'Correct' ? '<i class=\"fas fa-check\"></i> Correct!' : '<i class=\"fas fa-times\"></i> Incorrect!');
                    $('#mcq-feedback').removeClass('correct wrong').addClass(response.data.result === 'Correct' ? 'correct' : 'wrong');
                    $('#mcq-feedback').show();
                } else {
                    $('#skip-btn').show();
                    $('#submit-btn').show();
                    $('#next-btn').hide();
                }
            } else if (questionType === 'truefalse') {
                $('#truefalseanswer').show();
                const tfAnswer = response.data.attempted;
                if (tfAnswer) {
                    $('#truefalsedropdown').hide();
                    $('#skip-btn').hide();
                    $('#submit-btn').hide();
                    $('#next-btn').show();
                    $('#tf-feedback').html(response.data.result === 'Correct' ? '<i class=\"fas fa-check\"></i> Correct!' : '<i class=\"fas fa-times\"></i> Incorrect!');
                    $('#tf-feedback').removeClass('correct wrong').addClass(response.data.result === 'Correct' ? 'correct' : 'wrong');
                    $('#tf-feedback').show();
                }
            } else if (questionType === 'text') {
                $('#textanswer').show();
                const textAnswer = response.data.attempted;
                if (textAnswer) {
                    $('#textanswerinput').hide();
                    $('#skip-btn').hide();
                    $('#submit-btn').hide();
                    $('#next-btn').show();
                    $('#text-feedback').html(response.data.result === 'Correct' ? '<i class=\"fas fa-check\"></i> Correct!' : '<i class=\"fas fa-times\"></i> Incorrect!');
                    $('#text-feedback').removeClass('correct wrong').addClass(response.data.result === 'Correct' ? 'correct' : 'wrong');
                    $('#text-feedback').show();
                }
            }
            if (time <= 0) {
                document.querySelector('#timer').textContent = 'Time is up!';
                $('#submit-btn').hide();
                $('#skip-btn').hide();
            }
            if (qn == totalQuestions) {
                $('#skip-btn').hide();
                $('#next-btn').hide();
            }
        } else {
            alert(response.message);
            window.location.href = quizList;
        }
    }

    // Add click handlers for MCQ buttons
    $('.option-btn').on('click', function() {
        $('.option-btn').removeClass('selected');
        $(this).addClass('selected');
        selectedAnswer = $(this).attr('datai'); // Store the answer ID
    });
", \yii\web\View::POS_END);
?>