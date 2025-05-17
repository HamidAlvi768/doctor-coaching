<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\grid\GridView;


$this->title = 'Quizzes List';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .ellipsis-btn {
        color: grey;
        cursor: pointer;
        border: none;
        background: none;
        padding: 0;
    }

    .ellipsis-btn:hover {
        color: darkgrey;
    }

    .modal-fullscreen {
        width: 100%;
        /* Full width */
        margin: 0;
        /* Remove default margin */
        max-width: none;
        /* Remove max-width */
    }

    .modal-fullscreen .modal-content {
        height: 100%;
        /* Full height */
        border-radius: 0;
        /* Remove border radius if needed */
    }

    .modal-background {
        background-image: url('../img/logo.png');
        /* Path to your image */
        background-size: 30%;
        /* Resize the image to fit the modal */
        background-position: center;
        /* Center the image */
        background-repeat: no-repeat;
        /* Prevent the image from repeating */
        position: absolute;
        /* Position it absolutely within the modal */
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 0.1;
        /* Set the opacity for dim effect */
        z-index: 1;
        /* Make sure it stays behind the content */
        height: calc(80% - 60px);
        pointer-events: none;
        /* Allow clicks and interactions to pass through */
    }

    @media (max-width:600px) {
        .modal-background {
            background-size: 70%;
            /* Resize the image to fit the modal */
        }
    }

    .email-overlay {
        color: #234262;
        font-weight: 600;
        opacity: 0.6;
        pointer-events: none;
        text-align: center;
        height: 60px;
    }

    .modal-content {
        position: relative;
        z-index: 2;
        /* Make sure the content is above the background */
    }

    #qtext {
        user-select: none;
        /* Disable text selection to prevent copy/paste */
        -webkit-user-select: none;
        /* For Safari */
        -moz-user-select: none;
        /* For Firefox */
        -ms-user-select: none;
        /* For IE/Edge */
    }
</style>
<div class="container mt-5 mb-5">
    <div class="card card-primary">
        <div class="card-header">
            <h6>Available Quizzes <a style="float:right;" class="btn btn-link" href="<?= \yii\helpers\Url::to(['/site/subscribedlectures?id=' . $_REQUEST['id']]) ?>">view lectures</a></h6>
        </div>
        <div class="card-body">
            <?php

            // Assuming you have GridView set up
            echo GridView::widget([
                'dataProvider' => new \yii\data\ArrayDataProvider([
                    'allModels' => $quizData,
                    'pagination' => [
                        'pageSize' => 100,
                    ],
                ]),
                'options' => ['class' => 'table table-hover removestripped'], // Add your classes here
                'columns' => [
                    [
                        'label' => 'Title',
                        'value' => function ($data) {
                            if (!$data['attempted']) {
                                $btn = Html::button('Attempt this quiz', [
                                    'class' => 'btn btn-secondary start-btn',
                                    'data-id' => $data['quiz']->id, // Assuming the quiz ID is available here
                                ]);
                            } else {
                                $btn = Html::a('View Results', ['quiz/result', 'id' => $data['quiz']->id], [
                                    'class' => 'btn btn-success',
                                    'data-id' => $data['quiz']->id, // Assuming the quiz ID is available here
                                ]);
                            }

                            $duration = Html::encode($data['quiz']->duration_in_minutes);
                            $startTime = Yii::$app->formatter->asDatetime($data['quiz']->start_at, 'php:d M y h:i A');
                            $endTime = Yii::$app->formatter->asDatetime($data['quiz']->end_at, 'php:d M y h:i A');
                            $h = '';
                            $h = $data['quiz']->title . '<br><span style="font-size:x-small">' . $data['quiz']->description . '</span>
                <p style="color:green; font-size:small"> duration in min: <span id="dinmin" style="font-weight:500">' . $duration . '</span>, you can attempt this quiz any time between <span style="font-weight:400">
                ' . $startTime . '</span> to <span style="font-weight:400;">' . $endTime . '</span></p>
                ' . '<span>' . $btn . '</span>';
                            return $h;
                        },
                        'format' => 'raw'
                    ],



                    // [
                    //     'label' => 'Statistics',
                    //     'format' => 'raw',
                    //     'value' => function($data) {
                    //         return ("Total: {$data['questionCount']} <br> Attempted: {$data['responseCount']}  ");
                    //     },
                    // ],

                ],
            ]);


            ?>
        </div>
    </div>
</div>
<!-- <div id="answermodalparent" class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Question</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="answermodal">
        <p id="qtext">question_text here</p>
        <section id="multipleanswer" style="display:none;">
            <div class="row">
                <div id="optiona" datai="" datat="" class="col-md-6"></div>
                <div id="optionb" datai="" datat="" class="col-md-6"></div>
                <div id="optionc" datai="" datat="" data="" class="col-md-6"></div>
                <div id="optiond" datai="" datat="" class="col-md-6"></div>
            </div>
            <div class="row">
                <label>select option</label>
                <select class="form-control" id="choseoptiondropdown">
                        <option value="a">a</option>
                        <option value="b">b</option>
                        <option value="c">c</option>
                        <option value="d">d</option>
                </select>
            </div>
           
        </section>
        <section id="truefalseanswer" style="display:none;">
            <select class="form-control" id="truefalsedropdown">
                    <option value="true">true</option>
                    <option value="false">false</option>
            </select>
        </section>
        <section id="textanswer" style="display:none;">
            <textarea class="form-control" row="3" id="textanswerinput"></textarea>
        </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button onclick="answersubmitted();" type="button" id="submitanswer" class="btn btn-primary">submit answer</button>
      </div>
    </div>
  </div>
</div> -->
<div id="answermodalparent" class="modal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Question <span id="qnumber"></span>

                </h5>
                <span style="float:right;" id="timer" class="btn btn-danger"></span>
            </div>
            <div style="padding-left:40px; padding-right:40px;" class="modal-body" id="answermodal">
                <p style="color:red;" id="qtext">question_text here</p>
                <section id="multipleanswer" style="display:none;">
                    <div class="row">
                        <div id="optiona" datai="" datat="" class="col-md-6"></div>
                        <div id="optionb" datai="" datat="" class="col-md-6"></div>
                        <div id="optionc" datai="" datat="" class="col-md-6"></div>
                        <div id="optiond" datai="" datat="" class="col-md-6"></div>
                    </div>
                    <div class="row">
                        <label>select correct option</label>
                        <select class="form-control" id="choseoptiondropdown">
                            <option value="a">a</option>
                            <option value="b">b</option>
                            <option value="c">c</option>
                            <option value="d">d</option>
                        </select>
                    </div>
                </section>
                <section id="truefalseanswer" style="display:none;">
                    <label>select correct option</label>
                    <select class="form-control" id="truefalsedropdown">
                        <option value="true">true</option>
                        <option value="false">false</option>
                    </select>
                </section>
                <section id="textanswer" style="display:none;">
                    <label>Enter your answer</label>
                    <textarea class="form-control" rows="3" id="textanswerinput"></textarea>
                </section>
            </div>
            <div class="modal-background"></div>
            <div class="email-overlay">Logged in as: <?= Yii::$app->user->identity->email ?></div>
            <div class="modal-footer">
                <button onclick="$('#qtext').hide(); if (confirm('If you close this window, you will not be able to reattempt this exam. Are you sure you want to proceed?')) { $('#answermodalparent').hide(); } else { $('#qtext').show(); }"
                    type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button onclick="answersubmitted(this);" type="button" id="submitanswer" class="btn btn-primary">submit answer</button>
                <button onclick="answersubmitted(this);" type="button" id="skip_answer" class="btn btn-success">skip</button>
            </div>
        </div>
    </div>
</div>


<?php

// Generate the URL in PHP first
$url = \yii\helpers\Url::to(['quiz/attempt']);
$url2 = \yii\helpers\Url::to(['question/attempt']);
$url3 = \yii\helpers\Url::to(['question/submitanswer']);
// Register the JavaScript code with the correct URL
$this->registerJs("
$('.removestripped').removeClass('table-striped');
$('.removestripped').removeClass('table-bordered');
 
    var url = '{$url}'; 
    var url2 = '{$url2}';
    var url3 = '{$url3}'; 
    var csrfToken = $('meta[name=\"csrf-token\"]').attr('content');
    var id = null;
    var rid = null;
    

    function runtimer(totalSeconds){
        totalSeconds = totalSeconds;
        var countdownTimer = setInterval(function() {
            // Calculate minutes and seconds
            var minutes = Math.floor(totalSeconds / 60);
            var seconds = totalSeconds % 60;

            // Format the timer display
            var formattedTime = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
            $('#timer').text(formattedTime);

            // Decrease the total seconds
            totalSeconds--;

            // Check if the countdown has ended
            if (totalSeconds < 0) {
                clearInterval(countdownTimer); // Stop the timer
                $('#timer').text('00:00'); // Display 00:00
                $('.btn-close').click(); // Close the modal
                $('#answermodalparent').hide();
            }
        }, 1000);
    }

    $(document).on('click', '.start-btn', function() {
    var confirmation = confirm('You have only one chance to complete this exam. If you proceed, you cannot reattempt it. Do you want to continue?');
        if (confirmation) {
             
             var dinmin = parseInt($(this).parents('td:first').find('#dinmin').text(), 10);
            var totalSeconds = dinmin * 60; // Convert minutes to seconds
            runtimer(totalSeconds);
            $(this).addClass('disabled');
            id = $(this).data('id');
        
            $.post(url, { id: id, _csrf: csrfToken }, function(response) {
                if (response.success) {
                   
                    {
                        getquestion();
                    }


                } else {
                    alert('Error: ' + response.message);
                }
            }).fail(function() {
                console.log('Failed to send request.');
            });
        }
    });

    function answersubmitted(tt){
                    var url3 = '{$url3}';
                    var aid = $('#choseoptiondropdown').val();
                    var at = null;
                    if(aid == 'a'){
                        aid = $('#optiona').attr('datai');
                        at = $('#optiona').attr('datat');
                    }
                        if(aid == 'b'){
                        aid = $('#optionb').attr('datai');
                        at = $('#optionb').attr('datat');
                    }
                        if(aid == 'c'){
                        aid = $('#optionc').attr('datai');
                        at = $('#optionc').attr('datat');
                    }
                        if(aid == 'd'){
                        aid = $('#optiond').attr('datai');
                        at = $('#optiond').attr('datat');
                    }
                    
                    if($('#truefalsedropdown').val() != ''){
                        at = $('#truefalsedropdown').val()
                    }
                    if($('#textanswerinput').val() != ''){
                        at = $('#textanswerinput').val();
                    }
                        
                    if($(tt).attr('id') == 'skip_answer'){
                        aid = '';
                    }
                    $.post(url3, { id: rid, _csrf: csrfToken, aid: aid, at:at }, function(response) {
                        if (response == true || response == 'true' || response == 1 || response == '1') {
                        
                            getquestion();
                        }
                        else{
                            var responseInt = parseInt(response, 10);

                            if (!isNaN(responseInt)) {
                                //it means answer was skipped thats why response is having some integer in it pass it to getquestion
                                getquestion(response);
                            }
                            else{
                                alert('error in submitting answer');
                            }
                        }  
                    });
    }

// document.addEventListener('keydown', function(e) {
//     if (e.key === 'PrintScreen') {
//         alert('Screenshots are not allowed!');
//         e.preventDefault();
//     }
// });
// document.addEventListener('contextmenu', function(e) {
//     e.preventDefault(); // Disable right-click context menu
// });

// // Disable common developer tools shortcuts (F12, Ctrl+Shift+I, Ctrl+Shift+J, etc.)
// document.addEventListener('keydown', function(e) {
//     if (e.keyCode === 123 || (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74))) {
//         e.preventDefault();
//     }
// });

    function getquestion(rid_=null){
                    $('#truefalseanswer').val('');
                    $('#textanswerinput').val('');
                    $('#choseoptiondropdown').val('');
                    if(rid_ != null){
                        data_ = { id: id, rid_: rid_, _csrf: csrfToken }
                    }else{
                        data_ = { id: id, _csrf: csrfToken }
                    }
                    $.post(url2, data_, function(response) {
                        if (response.success) {
                            rid = response.data.rid;
                           
                            $('#answermodal #qtext').text('');
                            $('#multipleanswer, #truefalseanswer, #textanswer').hide();
                            $('#multipleanswer #optiona, #multipleanswer #optionb, #multipleanswer #optionc, #multipleanswer #optiond').empty();
                            
                            // Populate question text
                            $('#answermodal #qtext').text(response.data.question.question_text);
                           // $('#qnumber').text(response.data.question.qnumber);
                            // Determine question type
                            var questionType = response.data.question.type;

                            if (questionType === 'mcq') {
                                // Show multiple answers section
                                $('#multipleanswer').show();
                                
                                // Populate options
                                var answers = response.data.answers;
                                var options = ['a', 'b', 'c', 'd'];
                                
                                for (var i = 0; i < answers.length; i++) {
                                    if(i==0){ t = 'a';} if(i==1){ t = 'b';} if(i==2){ t = 'c';} if(i==3){ t = 'd';}
                                    if (options[i]) {
                                        $('#multipleanswer #option' + options[i]).text(t+') '+answers[i].answer_text);
                                         $('#multipleanswer #option' + options[i]).attr('datat', answers[i].answer_text);
                                         $('#multipleanswer #option' + options[i]).attr('datai', answers[i].id);
                                    }
                                }

                            } else if (questionType === 'truefalse') {
                                // Show true/false answer section
                                $('#truefalseanswer').show();

                            } else if (questionType === 'text') {
                                // Show text answer section
                                $('#textanswer').show();
                            }

                            // Show the modal (if not already shown)
                            //$('#modalopen').click();
                            $('#answermodalparent').show();

                        } else {
                            $('.btn-close').click();
                            alert('' + response.message);
                            location.reload();
                            
                        }
                    }).fail(function() {
                        console.log('Failed to send request.');
                    });
    }
", \yii\web\View::POS_END);


?>