<?php

namespace app\models;

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
            [['unit', 'status'], 'required'],
            [['id'], 'required', 'message' => 'Vui lòng nhập Mã Loại tải trọng Xe.'],
            [['vehicle_weight'], 'required', 'message' => 'Vui lòng nhập Tải trọng cho phép.'],
            ['vehicle_weight', 'double', 'message' => 'Vui lòng nhập một số lớn hơn 0.'],
            ['vehicle_weight', 'compare', 'compareValue' => 0, 'operator' => '>', 'message' => 'Vui lòng nhập một số lớn hơn 0.'],
            [['status'], 'integer'],
            [['id'], 'string', 'max' => 300],
            [['unit'], 'string', 'max' => 50],
            [['id'], 'unique', 'message' => 'Mã Loại tải trọng Xe này đã tồn tại.'],
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
            self::STATUS_NOT_ACTIVE => 'Không hoạt động',
            self::STATUS_ACTIVE => 'Hoạt động',
            self::STATUS_DELETED => 'Đã xóa'
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
