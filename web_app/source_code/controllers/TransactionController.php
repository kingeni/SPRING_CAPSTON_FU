<?php

namespace app\controllers;

use app\models\search\TransactionSearch;
use app\models\Transaction;
use app\models\User;
use app\models\Vehicle;
use app\models\VehicleWeight;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
use ElephantIO\Exception\ServerConnectionFailureException;
use kartik\mpdf\Pdf;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TransactionController implements the CRUD actions for Transaction model.
 */
class TransactionController extends Controller
{
    protected $socket;

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
     * Lists all Transaction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transaction model.
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
     * Creates a new Transaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transaction();
        $model->img_url = 'a';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Transaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $vehicle = Vehicle::findOne($model->vehicle_id);
            $vehicleWeight = VehicleWeight::findOne($vehicle->vehicle_weight_id);
            if ($model->vehicle_weight > $vehicleWeight->vehicle_weight) {
                $model->status = Transaction::STATUS_OVERLOAD;
            } else {
                $model->status = Transaction::STATUS_DONE;
            }
            if ($model->save()) {
                try {
                    $client = new Client(new Version2X('http://localhost:1337'));
                    $client->initialize();
                    $client->emit('new_transaction', ['message' => 'have_new_transaction: ' . $model->created_at]);
                    $client->close();
                } catch (ServerConnectionFailureException  $e) {
                }

                $content = $this->renderPartial('report', ['model' => $model]);
                $pdf = new Pdf([
                    'mode' => Pdf::MODE_UTF8,
                    'format' => Pdf::FORMAT_A4,
                    'orientation' => Pdf::ORIENT_PORTRAIT,
                    'destination' => Pdf::DEST_BROWSER,
                    'filename' => 'report' . ".pdf",
                    'content' => $content,
                    'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
                    'cssInline' => '.kv-heading-1{font-size:18px}',
                    'options' => ['title' => 'VWMS', 'keywords' => 'krajee, grid, export, yii2-grid, pdf, detail-view'],
                    'methods' => [
                        'SetHeader' => ['VWMS'],
                    ]
                ]);
                $mpdf = $pdf->api;
                $mpdf->WriteHTML($content);
                $mpdf->Output(Yii::getAlias('data/report/' . $model->id . '.pdf'));

                $vehicle = Vehicle::findOne($model->vehicle_id);
                $user = User::findOne($vehicle->user_id);
                $mail = Yii::$app->mailer->compose();
                $mail->setFrom('huyta.gaming@gmail.com');
                if ($user->email != null) {
                    try {
                        $mail->setTo($user->email);
                        $mail->setSubject('PHIẾU CÂN KIỂM TRA TẢI TRỌNG XE - ' . $model->created_at);
                        $mail->setTextBody('Đính kèm trong mail này là Phiếu cân kiểm tra tải trọng xe.');
                        $mail->attach(Yii::getAlias('data/report/' . $model->id . '.pdf'));
                        $mail->send();
                    } catch (\Swift_TransportException $e) {
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionCancel($id)
    {
        $model = $this->findModel($id);
        $model->status = Transaction::STATUS_CANCEL;
        $model->save();
        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Deletes an existing Transaction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (file_exists($this->findModel($id)->img_url))
            unlink($this->findModel($id)->img_url);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaction::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpdateTransaction()
    {
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];

//        $pagination = $dataProvider->getPagination();
//        $pagination->route = 'transaction/index';
        return $this->renderPartial('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    public function actionGeneratePdf($id)
    {
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('report', ['model' => $this->findModel($id)]);
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            'filename' => 'report' . ".pdf",
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}
                            .tbl {
                            border: 1px solid black;
                            border-collapse: collapse;
                            }',
            // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title', 'keywords' => 'krajee, grid, export, yii2-grid, pdf, detail-view'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ['VWMS'],
//                'SetFooter' => ['{PAGENO}'],
            ]
        ]);
//        $mpdf = $pdf->api;
//        $mpdf->WriteHTML($content);
//        $mpdf->Output(Yii::getAlias('data/report/' . $id . '.pdf'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'application/pdf');
        return $pdf->render();
    }
}
