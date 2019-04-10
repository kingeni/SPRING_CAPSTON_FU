<?php

namespace app\controllers;

use app\models\search\VehicleSearch;
use app\models\Vehicle;
use app\models\VehicleImg;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * VehicleController implements the CRUD actions for Vehicle model.
 */
class VehicleController extends Controller
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
     * Lists all Vehicle models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VehicleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vehicle model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Vehicle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Vehicle();

        if ($model->load(Yii::$app->request->post())) {
            $model->status = Vehicle::STATUS_ACTIVE;
            $model->expiration_date = date("Y-m-d", strtotime($model->expiration_date));
            if ($model->save()) {
                $listImg = UploadedFile::getInstances($model, 'img_url');
                $count = 0;
                foreach ($listImg as $img) {
                    $modelImg = new VehicleImg();
                    $modelImg->vehicle_id = $model->id;
                    $img->saveAs('data/vehicle_img/' . $modelImg->vehicle_id . '_' . $count . '.' . $img->extension);
                    $modelImg->img_url = 'data/vehicle_img/' . $modelImg->vehicle_id . '_' . $count . '.' . $img->extension;
                    $modelImg->save();
                    $count++;
                }
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $model->expiration_date = date("d-m-Y", strtotime($model->expiration_date));
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Vehicle model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $listVehicleImg = VehicleImg::findAll(['vehicle_id' => $id]);
        if (count($listVehicleImg) > 0) {
            foreach ($listVehicleImg as $item)
                $model->img_url[] = $item->img_url;
        }
        $model->expiration_date = date("d-m-Y", strtotime($model->expiration_date));
        if ($model->load(Yii::$app->request->post())) {
            $model->expiration_date = date("Y-m-d", strtotime($model->expiration_date));
            if ($model->save()) {
                $listImg = UploadedFile::getInstances($model, 'img_url');
                if ($listImg != null) {
                    VehicleImg::removeOldImg($model->id);
                    $count = 0;
                    foreach ($listImg as $img) {
                        $modelImg = new VehicleImg();
                        $modelImg->vehicle_id = $model->id;
                        $img->saveAs('data/vehicle_img/' . $modelImg->vehicle_id . '_' . $count . '.' . $img->extension);
                        $modelImg->img_url = 'data/vehicle_img/' . $modelImg->vehicle_id . '_' . $count . '.' . $img->extension;
                        $modelImg->save();
                        $count++;
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $model->expiration_date = date("d-m-Y", strtotime($model->expiration_date));
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Vehicle model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $vehicle = $this->findModel($id);
        if ($vehicle != null) {
            $vehicle->status = Vehicle::STATUS_DELETED;
            $vehicle->save();
        }
//        VehicleImg::removeOldImg($id);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Vehicle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Vehicle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vehicle::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
