<?php

namespace app\controllers;

use app\components\Helper;
use app\models\Session;
use app\models\SessionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii;
use app\models\User;
use app\models\UserSearch;
use app\models\Quiz;
use app\models\QuizSearch;
use app\models\Video;
use yii\web\ForbiddenHttpException;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\models\StudentSessionAssignment;

use yii\web\UploadedFile;

/**
 * SessionController implements the CRUD actions for Session model.
 */
class SessionController extends Controller
{
    public function beforeAction($action)
    {
        $actionId = $action->id;
        $verificationId = 'verify-otp';

        // Check if the user is logged in
        if (!Yii::$app->user->isGuest) {
            if (Helper::checkTimeAndLogout()) {
                return Yii::$app->response->redirect(["site/login"]);
            }
            $user = Yii::$app->user->identity;

            // If OTP is not verified, redirect the user to the OTP verification page
            if ($user && empty($user->email_verified) && $actionId !== $verificationId) {
                Yii::$app->response->redirect(["site/$verificationId"]);
                return false;  // Prevent further action execution
            }
        }

        // If the user is not logged in or OTP is verified, proceed with the action
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Session models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }


        $searchModel = new SessionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAllvideos()
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }


        $v = Video::find()->orderBy(['id' => SORT_DESC])->all();


        return $this->render('allvideos', [
            'video' => $v,
        ]);
    }

    /**
     * Displays a single Session model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    /**
     * Creates a new Session model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }


        $model = new Session();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['update', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Session model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }


        $model = $this->findModel($id);
        $userIdsInSession = $model->getUsers()->select('id')->column(); // Get IDs of users in the current session

        $usermodel = new UserSearch();
        $allusers = $usermodel->search(Yii::$app->request->queryParams, $userIdsInSession);

        $allquizz = Quiz::find()->where(['session_id' => $model->id])->orderBy(['id' => SORT_DESC])->limit(500)->asArray()->all();
        $videos = Video::find()->where(['session_id' => $id])->all();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'allusers' => $allusers,
            'allquizz' => $allquizz,
            'usermodel' => $usermodel,
            'quizmodel' => null,
            'videos' => $videos
        ]);
    }

    public function actionLectureupdate($id)
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }

        $size = Helper::getFolderSize(Yii::getAlias('@app/uploads/videos'));
        $sizeInMB = round($size / (1024 * 1024), 2);
        $sizeInGB = round($sizeInMB / 1024, 2);

        $video = Video::findOne($id);
        $model = $video;
        //  echo"<pre>";var_dump($model); exit;
        $sessions = ArrayHelper::map(Session::find()->all(), 'id', 'name');
        return $this->render('online_lecture', [
            'model' => $model,
            'sessions' => $sessions,
            'video' => $video,
            'size' => $sizeInGB
        ]);
    }

    public function actionStream($id)
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }

        // Decode the base64-encoded ID
        $encryptedId = base64_decode($id);

        // Decrypt the ID using the same secret key
        $decryptedId = Yii::$app->security->decryptByKey($encryptedId, 'rmabsalibaig');

        if ($decryptedId !== false) {
            // Now you have the decrypted ID, you can use it to find the video
            $file = Video::findOne($decryptedId);

            if ($file) {
                $filePath = Yii::getAlias('@app/') . $file->file_path;
                //var_dump($filePath); exit;
                if (file_exists($filePath)) {

                    $session = Session::findOne($file->session_id);
                    if (!$session) {

                        throw new NotFoundHttpException("File not found or you are not allowed to view this file");
                    }

                    $session = StudentSessionAssignment::find()->where(['student_id' => Yii::$app->user->id, 'session_id' => $session->id])->one();
                    if (Yii::$app->user->identity->usertype == 'admin') {
                        return Yii::$app->response->sendFile($filePath, $file->file_path, [
                            'mimeType' => 'video/mp4',
                            'inline' => true,
                        ]);
                    } else {
                        if ($session) {
                            return Yii::$app->response->sendFile($filePath, $file->file_path, [
                                'mimeType' => 'video/mp4',
                                'inline' => true,
                            ]);
                        } else {
                            throw new NotFoundHttpException("File not found or you are not allowed to view this file");
                        }
                    }
                } else {
                    throw new NotFoundHttpException("File not found.");
                }
            }

            throw new NotFoundHttpException("Video not found.");
        } else {
            throw new NotFoundHttpException("Invalid ID.");
        }
    }

    // public function actionLecture()
    // {
    //     // echo"<pre>"; var_dump($_REQUEST); exit;
    //     if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
    //         throw new ForbiddenHttpException('You are not allowed to access this page.');
    //     } {
    //         //for update
    //         if (isset($_REQUEST['Video']['id']) && $_REQUEST['Video']['id'] != null) {
    //             $video = Video::findOne($_REQUEST['Video']['id']);
    //             $video->session_id = $_REQUEST['Video']['session_id'];
    //             $video->title = $_REQUEST['Video']['title'];
    //             $video->description = $_REQUEST['Video']['description'];
    //             $video->save(false);
    //             Yii::$app->session->setFlash('success', 'Lecture updated successfully.');
    //             return $this->redirect(['session/lectureupdate', 'id' => $_REQUEST['Video']['id']]);
    //         }
    //     }

    //     if (Yii::$app->request->isPost && isset($_REQUEST['Video']['quiz_id'])) {
    //         $model = new Video();

    //         // Get current folder size
    //         $folderPath = Yii::getAlias('@app/uploads/videos');
    //         $currentSizeInBytes = Helper::getFolderSize($folderPath);
    //         $currentSizeInMB = round($currentSizeInBytes / (1024 * 1024), 2);
    //         $currentSizeInGB = round($currentSizeInMB / 1024, 2);

    //         if ($model->file_path) {

    //             // Get the size of the uploaded file in bytes
    //             $uploadedFileSizeInBytes = $model->file_path->size;
    //             $uploadedFileSizeInGB = round($uploadedFileSizeInBytes / (1024 * 1024 * 1024), 2);

    //             // Calculate total size after upload (in GB)
    //             $totalSizeInGB = $currentSizeInGB + $uploadedFileSizeInGB;

    //             // Define the size limit (97 GB)
    //             $sizeLimitInGB = 97;

    //             // Check if total size exceeds 97 GB
    //             if ($totalSizeInGB > $sizeLimitInGB) {
    //                 Yii::$app->session->setFlash('error', "Upload failed: Total size ({$totalSizeInGB} GB) exceeds the 97 GB limit.");
    //                 // Redirect back to the referring URL or a default URL
    //                 $referrer = Yii::$app->request->referrer ?: ['quiz/update', 'id' => $_REQUEST['Video']['quiz_id']];
    //                 return $this->redirect($referrer);
    //             }

    //             $filePath = 'uploads/videos/' . uniqid() . '.' . $model->file_path->extension;
    //             $model->file_path->saveAs($filePath);
    //             $model->file_path = $filePath;

    //             $model->quiz_id = $_REQUEST['Video']['quiz_id'];
    //             $model->title = $_REQUEST['Video']['title'];
    //             $model->description = $_REQUEST['Video']['description'];

    //             // echo"<pre>"; var_dump($model); exit;
    //             if ($model->save(false)) {
    //                 Yii::$app->session->setFlash('success', 'Lecture uploaded successfully.');
    //                 return $this->redirect(['session/lectureupdate', 'id' => $model->id]);
    //             }
    //         }
    //     } else {
    //         $model = new Video();
    //     }

    //     $size = Helper::getFolderSize(Yii::getAlias('@app/uploads/videos'));
    //     $sizeInMB = round($size / (1024 * 1024), 2);
    //     $sizeInGB = round($sizeInMB / 1024, 2);

    //     $sessions = ArrayHelper::map(Session::find()->all(), 'id', 'name');

    //     // $videos = Video::find()->where(['session_id' => $id])->all();
    //     return $this->render('online_lecture', [
    //         'model' => $model,
    //         'sessions' => $sessions,
    //         'size' => $sizeInGB
    //         //    'video' => $videos
    //     ]);
    // }

    public function actionLecture()
    {
        // Restrict access to admin only
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->usertype !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }

        // Check if it's an update request
        if (isset($_REQUEST['Video']['id']) && $_REQUEST['Video']['id'] != null) {
            $video = Video::findOne($_REQUEST['Video']['id']);
            if ($video) {
                $video->quiz_id = $_REQUEST['Video']['quiz_id'];
                $video->title = $_REQUEST['Video']['title'];
                $video->description = $_REQUEST['Video']['description'];
                if ($video->save(false)) {
                    Yii::$app->session->setFlash('success', 'Lecture updated successfully.');
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to update lecture.');
                }
            }
            return $this->redirect(['session/lectureupdate', 'id' => $_REQUEST['Video']['id']]);
        }

        $model = new Video();

        // Handle file upload when POST request
        if (Yii::$app->request->isPost && isset($_REQUEST['Video']['quiz_id'])) {

            // Get current folder size
            $folderPath = Yii::getAlias('@app/uploads/videos');
            $currentSizeInBytes = Helper::getFolderSize($folderPath);
            $currentSizeInGB = round($currentSizeInBytes / (1024 * 1024 * 1024), 2); // Converted to GB

            // Handle file upload
            $uploadedFile = UploadedFile::getInstance($model, 'file_path');
            if ($uploadedFile) {
                $uploadedFileSizeInGB = round($uploadedFile->size / (1024 * 1024 * 1024), 2); // Convert to GB
                $totalSizeInGB = $currentSizeInGB + $uploadedFileSizeInGB;

                // Define the size limit (97 GB)
                $sizeLimitInGB = 97;

                // Check if total size exceeds the limit
                if ($totalSizeInGB > $sizeLimitInGB) {
                    Yii::$app->session->setFlash('error', "Upload failed: Total size ({$totalSizeInGB} GB) exceeds the 97 GB limit.");
                    return $this->redirect(Yii::$app->request->referrer ?: ['quiz/update', 'id' => $_REQUEST['Video']['quiz_id']]);
                }

                // Save the uploaded file
                $filePath = 'uploads/videos/' . uniqid() . '.' . $uploadedFile->extension;
                if ($uploadedFile->saveAs($filePath)) {
                    $model->file_path = $filePath;
                } else {
                    Yii::$app->session->setFlash('error', 'File upload failed.');
                    return $this->redirect(Yii::$app->request->referrer ?: ['quiz/update', 'id' => $_REQUEST['Video']['quiz_id']]);
                }

                // Assign other model attributes
                $model->quiz_id = $_REQUEST['Video']['quiz_id'];
                $model->title = $_REQUEST['Video']['title'];
                $model->description = $_REQUEST['Video']['description'];

                // Save the video record
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Lecture uploaded successfully.');
                    return $this->redirect(['session/lectureupdate', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to save lecture.');
                }
            }
        }

        // Get folder size for rendering view
        $sizeInGB = round(Helper::getFolderSize(Yii::getAlias('@app/uploads/videos')) / (1024 * 1024 * 1024), 2);
        $sessions = ArrayHelper::map(Session::find()->all(), 'id', 'name');

        return $this->render('online_lecture', [
            'model' => $model,
            'sessions' => $sessions,
            'size' => $sizeInGB,
        ]);
    }



    /**
     * Deletes an existing Session model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionLecturedelete($id, $is_session = null)
    {
        // Find the quiz by its ID
        $model = Video::findOne($id);

        if ($model) {
            // Delete the file from the server
            $filePath = Yii::getAlias('@webroot') . '/' . $model->file_path;  // Example file path

            if (file_exists($filePath)) {
                // Attempt to delete the file
                if (unlink($filePath)) {
                    // Delete the quiz
                    $model->delete();
                    // Set a success flash message
                    Yii::$app->session->setFlash('success', 'Video deleted successfully.');
                } else {
                    Yii::$app->session->setFlash('error', 'Error: File could not be deleted.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Error: File does not exist.');
            }
        } else {
            // Set an error flash message
            Yii::$app->session->setFlash('error', 'Video not found.');
        }
        if ($is_session) {
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->redirect(['session/allvideos']);
    }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Session model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Session the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Session::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
