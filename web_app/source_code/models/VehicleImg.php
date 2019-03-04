<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicle_img".
 *
 * @property int $id
 * @property string $img_url
 * @property string $created_at
 * @property string $vehicle_id
 */
class VehicleImg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle_img';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['img_url', 'vehicle_id'], 'required'],
            [['created_at'], 'safe'],
            [['img_url'], 'string', 'max' => 1000],
            [['vehicle_id'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'img_url' => 'Img Url',
            'created_at' => 'Created At',
            'vehicle_id' => 'Vehicle ID',
        ];
    }

    public static function getVehicleImgByVehicleId($vehicleId)
    {
        return VehicleImg::findAll(['vehicle_id' => $vehicleId]);
    }

    public static function removeOldImg($vehicleId)
    {
        $listVehicleImg = VehicleImg::findAll(['vehicle_id' => $vehicleId]);
        if (count($listVehicleImg) > 0) {
            foreach ($listVehicleImg as $item) {
                unlink($item->img_url);
                $item->delete();
            }
        }
    }

    public static function checkImg($img_url)
    {
        $url = 'data/vehicle_img/' . $img_url;
        $listVehicleImg = VehicleImg::findAll(['img_url' => $url]);
        if (count($listVehicleImg) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
