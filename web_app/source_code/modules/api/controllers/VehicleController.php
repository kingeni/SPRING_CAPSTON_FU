<?php
/**
 * Created by PhpStorm.
 * User: Huy Ta
 * Date: 2/26/2019
 * Time: 9:29 PM
 */

namespace app\modules\api\controllers;


use app\models\Transaction;
use app\models\Vehicle;
use app\models\VehicleImg;
use app\models\VehicleWeight;
use yii\helpers\Json;
use yii\web\Controller;

class VehicleController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionGetVehicles($userId)
    {
        $listVehicle = Vehicle::find()->asArray()->where(['user_id' => $userId])->all();
        $arr = [];
        if (count($listVehicle) > 0) {
            foreach ($listVehicle as $item) {
                $item['number_of_violations'] = count(Transaction::find()->where(['vehicle_id' => $item['id']])->andWhere(['status' => 2])->all());
                $item['number_of_unread'] = count(Transaction::find()->where(['vehicle_id' => $item['id']])->andWhere(['is_read' => 0])->all());
                $item['newest_transaction'] = Transaction::find()->where(['vehicle_id' => $item['id']])->orderBy(['created_at' => SORT_DESC])->one();
                $arr[] = $item;
            }
        }
        return Json::encode($arr);
    }

    public function actionGetVehicleImg($vehicleId)
    {
        $listVehicleImg = VehicleImg::findAll(['vehicle_id' => $vehicleId]);
        $arr = [];
        if (count($listVehicleImg) > 0) {
            $count = 0;
            foreach ($listVehicleImg as $item) {
                $data = file_get_contents($item->img_url);
                $arr[] = [
                    'img' . $count => base64_encode($data)
                ];
                $count++;
            }
        }
        return Json::encode($arr);
    }

    public function actionGetPlateByTagId($tagId)
    {
        $vehicle = Vehicle::find()->asArray()->where(['id' => $tagId])->one();
        if ($vehicle != null) {
            $vehicle['vehicle_maxload'] = VehicleWeight::findOne(['id' => $vehicle['vehicle_weight_id']])->vehicle_weight;
            unset ($vehicle['vehicle_weight_id']);
            return Json::encode($vehicle);
        } else {
            return Json::encode(['license_plates' => 'not_found']);
        }
    }


}