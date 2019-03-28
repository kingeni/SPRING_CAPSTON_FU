<?php
/**
 * Created by PhpStorm.
 * User: Huy Ta
 * Date: 2/26/2019
 * Time: 9:27 PM
 */

namespace app\modules\api\controllers;

use app\models\Transaction;
use app\models\User;
use app\models\Vehicle;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
use ElephantIO\Exception\ServerConnectionFailureException;
use kartik\mpdf\Pdf;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class TransactionController extends Controller
{
    protected $socket;
    public $enableCsrfValidation = false;

    public function actionGetTransactions($vehicleId)
    {
        $listTransactions = Transaction::find()->where(['vehicle_id' => $vehicleId])->orderBy(['created_at' => SORT_DESC])->all();
        if (count($listTransactions) > 0) {
            foreach ($listTransactions as $item) {
                if (file_exists($item->img_url))
                    $item->img_url = base64_encode(file_get_contents($item->img_url));
            }
        }
        return Json::encode($listTransactions);
    }

    public function actionGetVTransactions($vehicleId)
    {
        $listTransactions = Transaction::find()->where(['vehicle_id' => $vehicleId])->andWhere(['status' => Transaction::STATUS_OVERLOAD])->orderBy(['created_at' => SORT_DESC])->all();
        if (count($listTransactions) > 0) {
            foreach ($listTransactions as $item) {
                if (file_exists($item->img_url))
                    $item->img_url = base64_encode(file_get_contents($item->img_url));
            }
        }
        return Json::encode($listTransactions);
    }

    public function actionSubmitTransaction()
    {
        $model = new Transaction();
        $model->id = Yii::$app->request->post('id');
        $model->vehicle_weight = Yii::$app->request->post('vehicle_weight');
        $model->unit = Yii::$app->request->post('unit');;
        $model->created_at = date('Y-m-d H:i:s');

        //convert image
        $imgBase64 = Yii::$app->request->post('img');
        $imgUrl = 'data/transaction/' . $model->id . '.jpg';
        $file = fopen($imgUrl, 'wb');
        fwrite($file, base64_decode($imgBase64));
        fclose($file);

        $model->img_url = $imgUrl;
        $model->vehicle_id = Yii::$app->request->post('vehicle_id');
        $model->station_id = Yii::$app->request->post('station_id');
        $model->status = Yii::$app->request->post('status');
        if ($model->validate() && $model->save()) {
            try {
                $client = new Client(new Version2X('http://localhost:1337'));
                $client->initialize();
                $client->emit('new_transaction', ['message' => 'have_new_transaction: ' . $model->created_at]);
                $client->close();
            } catch (ServerConnectionFailureException  $e) {
            }
            if (Yii::$app->request->post('status') == 3) {
                return Json::encode(['status' => 'NOT_OK']);
            } else {
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
            }
            return Json::encode(['status' => true]);
        }
        return Json::encode(['status' => false]);
    }

    public function actionGetTransaction($transactionId)
    {
        return Json::encode(Transaction::findOne(['id' => $transactionId]));
    }

    public function actionUpdateIsReadTransaction($vehicleId)
    {
        $listTransactions = Transaction::findAll(['vehicle_id' => $vehicleId]);
        if (count($listTransactions) > 0) {
            /* @var $item Transaction */
            foreach ($listTransactions as $item) {
                $item->is_read = 1;
                $item->save();
            }
        }
        return Json::encode(['status' => true]);
    }
}