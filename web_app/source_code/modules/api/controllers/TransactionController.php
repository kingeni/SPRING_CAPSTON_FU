<?php
/**
 * Created by PhpStorm.
 * User: Huy Ta
 * Date: 2/26/2019
 * Time: 9:27 PM
 */

namespace app\modules\api\controllers;

use app\models\Transaction;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class TransactionController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionGetTransactions($vehicleId)
    {
        $listTransactions = Transaction::findAll(['vehicle_id' => $vehicleId]);
        if (count($listTransactions) > 0) {
            foreach ($listTransactions as $item) {
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
        $model->unit_id = 1;
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
            if (Yii::$app->request->post('status') == 3) {
                return Json::encode(['status' => 'NOT_OK']);
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