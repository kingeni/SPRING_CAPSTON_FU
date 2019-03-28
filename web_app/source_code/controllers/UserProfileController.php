<?php

namespace app\controllers;

use Yii;
use app\models\UserProfile;
use app\models\search\UserProfileSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * UserProfileController implements the CRUD actions for UserProfile model.
 */
class UserProfileController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => !Yii::$app->user->isGuest,
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all UserProfile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserProfile model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($userId)
    {
        return $this->render('view', [
            'model' => $this->findModel($userId),
        ]);
    }

    /**
     * Creates a new UserProfile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id, $username)
    {
        $model = new UserProfile();
        $model->user_id = $id;

        if ($model->load(Yii::$app->request->post())) {
            $model->date_of_birth = date("Y-m-d", strtotime($model->date_of_birth));
            $img = UploadedFile::getInstance($model, 'img_url');
            $img->saveAs('data/user_profile/' . $model->user_id . '.' . $img->extension);
            $model->img_url = 'data/user_profile/' . $model->user_id . '.' . $img->extension;
            if ($model->save())
                return $this->redirect(['view', 'userId' => $model->user_id]);
        }

        return $this->render('create', [
            'id' => $id,
            'username' => $username,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserProfile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($userId)
    {
        $model = $this->findModel($userId);
        $url = $model->img_url;

        $model->date_of_birth = date("d-m-Y", strtotime($model->date_of_birth));
        if ($model->load(Yii::$app->request->post())) {
            $model->date_of_birth = date("Y-m-d", strtotime($model->date_of_birth));
            $img = UploadedFile::getInstance($model, 'img_url');
            if ($img != null) {
                unset($url);
                $img->saveAs('data/user_profile/' . $model->user_id . '.' . $img->extension);
                $model->img_url = 'data/user_profile/' . $model->user_id . '.' . $img->extension;
            } else {
                $model->img_url = $url;
            }
            if ($model->save()) {
                return $this->redirect(['view', 'userId' => $model->user_id]);
            } else {
                $model->date_of_birth = date("d-m-Y", strtotime($model->date_of_birth));
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserProfile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($userId)
    {
        $this->findModel($userId)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserProfile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
