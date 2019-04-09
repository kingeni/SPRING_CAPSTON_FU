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
use DateTime;
use yii\helpers\Json;
use yii\web\Controller;

class VehicleController extends Controller
{
    public $enableCsrfValidation = false;

//    public function actionGetVehicles($userId)
//    {
//        $listVehicle = Vehicle::find()->asArray()->where(['user_id' => $userId])->all();
//        $arr = [];
//        if (count($listVehicle) > 0) {
//            foreach ($listVehicle as $item) {
//                $vehicleWeight = VehicleWeight::findOne(['id' => $item['vehicle_weight_id']]);
//                if ($vehicleWeight != null) {
//                    $item['vehicle_maxload'] = $vehicleWeight->vehicle_weight;
//                    $item['vehicle_unit'] = $vehicleWeight->unit;
//                }
//
//                unset ($item['vehicle_weight_id']);
//                $item['number_of_violations'] = count(Transaction::find()->where(['vehicle_id' => $item['id']])->andWhere(['status' => 2])->all());
//                $item['number_of_unread'] = count(Transaction::find()->where(['vehicle_id' => $item['id']])->andWhere(['is_read' => 0])->all());
//                $item['newest_transaction'] = Transaction::find()->where(['vehicle_id' => $item['id']])->orderBy(['created_at' => SORT_DESC])->one();
//                $listVehicleImg = VehicleImg::findAll(['vehicle_id' => $item['id']]);
//                if (count($listVehicleImg) > 0) {
//                    $imgUrl = array_values($listVehicleImg)[0]->img_url;
//                    if (file_exists($imgUrl)) {
//                        $item['img'] = base64_encode(file_get_contents($imgUrl));
//                    } else {
//                        $item['img'] = null;
//                    }
//                } else {
//                    $item['img'] = null;
//                }
//                $arr[] = $item;
//            }
//        }
//        return Json::encode($arr);
//    }

    public function actionGetVehicles($userId)
    {
        $listVehicle = Vehicle::find()->asArray()->where(['user_id' => $userId])->all();
        $arr = [];
        if (count($listVehicle) > 0) {
            foreach ($listVehicle as $item) {
                $vehicleWeight = VehicleWeight::findOne(['id' => $item['vehicle_weight_id']]);
                if ($vehicleWeight != null) {
                    $item['vehicle_maxload'] = $vehicleWeight->vehicle_weight;
                    $item['vehicle_unit'] = $vehicleWeight->unit;
                }

                unset ($item['vehicle_weight_id']);
                $item['number_of_violations'] = count(Transaction::find()->where(['vehicle_id' => $item['id']])->andWhere(['status' => 2])->all());
                $item['number_of_unread'] = count(Transaction::find()->where(['vehicle_id' => $item['id']])->andWhere(['is_read' => 0])->all());
                $temp = Transaction::find()->where(['vehicle_id' => $item['id']])->orderBy(['created_at' => SORT_DESC])->one();
                if ($temp != null) {
                    $item['newest_transaction'] = $temp->created_at;
                } else {
                    $item['newest_transaction'] = null;
                }
                $listVehicleImg = VehicleImg::findAll(['vehicle_id' => $item['id']]);
                if (count($listVehicleImg) > 0) {
                    $imgUrl = array_values($listVehicleImg)[0]->img_url;
                    if (file_exists($imgUrl)) {
                        $item['img'] = base64_encode(file_get_contents($imgUrl));
                    } else {
                        $item['img'] = null;
                    }
                } else {
                    $item['img'] = null;
                }
                $arr[] = $item;
            }
        }
        if (count($arr) > 0) {
            usort($arr, function ($a, $b) {
                $ad = new DateTime($a['newest_transaction']);
                $bd = new DateTime($b['newest_transaction']);

                if ($ad == $bd) {
                    return 0;
                }

                return $ad < $bd ? -1 : 1;
            });
        }
        return Json::encode($arr);
    }

    public function actionGetVehicleImg($vehicleId)
    {
        $listVehicleImg = VehicleImg::findAll(['vehicle_id' => $vehicleId]);
        $arr = [];
        if (count($listVehicleImg) > 0) {
            foreach ($listVehicleImg as $item) {
                if (file_exists($item->img_url)) {
                    $data = file_get_contents($item->img_url);
                    $arr[] = [
                        'img0' => base64_encode($data)
                    ];
                } else {
                    $arr[] = [
                        'img0' => null
                    ];
                }
            }
        } else {
            $arr = ['img0' => null];
        }
        return Json::encode($arr);
    }

    public function actionGetPlateByTagId($tagId)
    {
        $vehicle = Vehicle::find()->asArray()->where(['id' => $tagId])->one();
        $vehicleWeight = VehicleWeight::findOne(['id' => $vehicle['vehicle_weight_id']]);
        if ($vehicle != null || $vehicleWeight != null) {
            $vehicle['vehicle_maxload'] = $vehicleWeight->vehicle_weight;
            $vehicle['vehicle_unit'] = $vehicleWeight->unit;
            unset ($vehicle['vehicle_weight_id']);
            return Json::encode($vehicle);
        } else {
            return Json::encode(['license_plates' => 'not_found']);
        }
    }


}