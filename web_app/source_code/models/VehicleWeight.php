<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "vehicle_weight".
 *
 * @property string $id
 * @property double $vehicle_weight
 * @property string $unit
 * @property int $status
 */
class VehicleWeight extends \yii\db\ActiveRecord
{
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    const UNIT_TON = 'tấn';
    const UNIT_KILOGRAM = 'kilogram';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle_weight';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'vehicle_weight', 'unit', 'status'], 'required'],
            [['vehicle_weight'], 'number', 'integerOnly' => true, 'min' => 0],
            [['status'], 'integer'],
            [['id'], 'string', 'max' => 300],
            [['unit'], 'string', 'max' => 50],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vehicle_weight' => 'Vehicle Weight',
            'unit_id' => 'Unit',
            'status' => 'Status',
        ];
    }

    public static function statuses()
    {
        return [
            self::STATUS_NOT_ACTIVE => 'Not Active',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DELETED => 'Deleted'
        ];
    }

    public static function units()
    {
        return [
            self::UNIT_TON => 'Tấn',
            self::UNIT_KILOGRAM => 'Kilogram',
        ];
    }

    public static function getListVehicleWeight()
    {
        return ArrayHelper::map(VehicleWeight::find()->where(['status' => VehicleWeight::STATUS_ACTIVE])->all(), 'id', 'id');
    }
}
