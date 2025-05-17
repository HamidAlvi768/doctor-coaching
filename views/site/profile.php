<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\View;

$this->title = 'Profile';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/jquery.fileupload.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$baseUrl = Yii::$app->request->baseUrl;
?>

<div class="main-page">
    <div class="page-header">
        <h2><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="page-content">
        <div class="card profile-card">
            <div class="card-body">
                <p>Please fill out the following fields to update your profile:</p>
                <?php $form = ActiveForm::begin(['id' => 'form-profile', 'fieldConfig' => [
                    'options' => ['class' => 'form-group col-lg-3 col-md-6 col-sm-12'],
                ]]); ?>

                <div class="row">
                    <?= $form->field($model, 'full_name')->textInput(['class' => 'form-control', 'required' => true]) ?>
                    <?= $form->field($model, 'father_name')->textInput(['class' => 'form-control', 'required' => true]) ?>
                    <?= $form->field($model, 'cnic')->textInput(['class' => 'form-control', 'required' => true]) ?>
                    <?= $form->field($model, 'gender')->dropDownList([
                        'male' => 'Male',
                        'female' => 'Female',
                        'other' => 'Other'
                    ], ['prompt' => 'Select Gender', 'required' => true]) ?>
                    <?= $form->field($model, 'number')->textInput(['class' => 'form-control']) ?>
                    <?= $form->field($model, 'city')->textInput(['class' => 'form-control']) ?>
                    <?= $form->field($model, 'email')->textInput(['class' => 'form-control']) ?>
                    <?= $form->field($model, 'new_password')->passwordInput(['value' => '', 'class' => 'form-control'])->label('New Password') ?>

                    <?= $form->field($model, 'uni')->textInput(['class' => 'form-control', 'required' => true]) ?>

                    <?= $form->field($model, 'workplace')->textInput(['class' => 'form-control', 'required' => true]) ?>


                </div>

                <div class="form-group sessions-group">
                    <label>Select Sessions:</label>
                    <?= Html::checkboxList('SignupForm[register_for]', explode(',', $model->register_for), \yii\helpers\ArrayHelper::map($sessions, 'id', 'name'), ['class' => 'checkbox-list']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Update Profile', ['class' => 'btn btn-primary', 'name' => 'profile-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

        <div class="card upload-card mt-5">
            <div class="card-header">
                Upload Fee Slip
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Upload Images:</label>
                    <div id="drag-and-drop-area" class="drag-drop-area">
                        Drag and drop images here or click to select files.
                        <input type="file" id="file-input" multiple accept="image/*" style="display:none;">
                    </div>

                    <div id="uploaded-images" class="image-gallery">
                        <?php foreach ($getImages as $image): ?>
                            <div class="image-wrapper">
                                <img src="<?= $baseUrl . '/' . $image->file_path ?>" alt="Fee Slip">
                                <button class="delete-image" data-path="<?= $image->file_path ?>">×</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
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
    }

    .page-content {
        width: 100%;
    }

    .profile-card,
    .upload-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .profile-card:hover,
    .upload-card:hover {
        transform: translateY(-5px);
    }

    .card-body {
        padding: 25px;
    }

    .card-body p {
        color: #234262;
        font-size: 1rem;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-control {
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        padding: 10px;
        font-size: 0.95rem;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: #234262;
        box-shadow: 0 0 5px rgba(35, 66, 98, 0.3);
    }

    label {
        color: #234262;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 5px;
        display: block;
    }

    .sessions-group {
        background: #f9f9f9;
        padding: 15px;
        border-radius: 5px;
    }

    .checkbox-list label {
        font-size: 0.9rem;
        color: #333;
        margin-bottom: 10px;
    }

    .btn-primary {
        background: #234262;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 1rem;
        font-weight: 500;
        transition: background 0.3s ease;
    }

    .btn-primary:hover {
        background: #2a5298;
    }

    .upload-card .card-header {
        background: #234262;
        color: #fff;
        padding: 15px;
        border-radius: 10px 10px 0 0;
        font-size: 1.2rem;
        font-weight: 600;
    }

    .drag-drop-area {
        border: 2px dashed #234262;
        padding: 30px;
        text-align: center;
        background: #f9f9f9;
        border-radius: 10px;
        color: #234262;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .drag-drop-area:hover {
        background: #e0e0e0;
    }

    .image-gallery {
        margin-top: 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .image-wrapper {
        position: relative;
        width: 100px;
        display: inline-block;
    }

    .image-wrapper img {
        width: 100%;
        height: auto;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .image-wrapper:hover img {
        transform: scale(1.05);
    }

    .delete-image {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #dc3545;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 12px;
        line-height: 20px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .delete-image:hover {
        background: #c82333;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header h2 {
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .sessions-group {
            padding: 10px;
        }

        .drag-drop-area {
            padding: 20px;
        }

        .image-wrapper {
            width: 80px;
        }
    }

    @media (max-width: 576px) {
        .main-page {
            padding: 10px;
        }

        .page-header {
            padding: 15px;
        }

        .row .form-group {
            width: 100%;
        }

        .image-gallery {
            justify-content: center;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
        }
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $('#drag-and-drop-area').on('click', function() {
        $('#file-input').click();
    });

    $('#file-input').on('change', function(e) {
        const files = e.target.files;
        previewImages(files);
        uploadFiles(files);
    });

    $('#drag-and-drop-area').on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });

    $('#drag-and-drop-area').on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const files = e.originalEvent.dataTransfer.files;
        previewImages(files);
        uploadFiles(files);
    });

    $(document).ready(function() {
        $('.delete-image').on('click', function() {
            const imagePath = $(this).data('path');
            deleteImage(imagePath, $(this).closest('.image-wrapper'));
        });
    });

    function previewImages(files) {
        let imagesHtml = '';
        for (let i = 0; i < files.length; i++) {
            const fileReader = new FileReader();
            fileReader.onload = function(event) {
                imagesHtml += '<div class="image-wrapper"><img src="' + event.target.result + '" alt="Preview"><button class="delete-image" disabled>×</button></div>';
                $('#uploaded-images').html(imagesHtml);
            };
            fileReader.readAsDataURL(files[i]);
        }
    }

    function uploadFiles(files) {
        let formData = new FormData();
        for (let i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
        }

        $.ajax({
            url: 'upload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                alert('Images uploaded!');
                $('#uploaded-images').empty();
                console.log(data);
                displayImages(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error uploading files: ' + textStatus);
            }
        });
    }

    function displayImages(imagePaths) {
        let imagesHtml = '';
        const baseUrl = '<?php echo Yii::$app->request->baseUrl; ?>';
        imagePaths.forEach(function(path) {
            imagesHtml += `
                <div class="image-wrapper">
                    <img src="${baseUrl}/${path}" alt="Fee Slip">
                    <button class="delete-image" data-path="${path}">×</button>
                </div>`;
        });
        $('#uploaded-images').append(imagesHtml);

        $('.delete-image').on('click', function() {
            const imagePath = $(this).data('path');
            deleteImage(imagePath, $(this).closest('.image-wrapper'));
        });
    }

    function deleteImage(imagePath, imageWrapper) {
        $.ajax({
            url: 'delete-image',
            type: 'POST',
            data: {
                path: imagePath
            },
            success: function(response) {
                if (response.success) {
                    alert('Images Deleted!');
                    imageWrapper.remove();
                } else {
                    console.log('Error deleting image:', response.error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error during AJAX request:', textStatus);
            }
        });
    }
</script>