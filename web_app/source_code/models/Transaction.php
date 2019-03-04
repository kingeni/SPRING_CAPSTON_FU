<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property string $id
 * @property int $vehicle_weight
 * @property string $unit
 * @property string $created_at
 * @property string $img_url
 * @property string $vehicle_id
 * @property string $station_id
 * @property int $is_read
 * @property int $status
 */
class Transaction extends \yii\db\ActiveRecord
{
    const STATUS_DONE = 1;
    const STATUS_OVERLOAD = 2;
    const STATUS_UNDONE = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'vehicle_weight', 'unit', 'created_at', 'img_url', 'vehicle_id', 'station_id', 'status'], 'required'],
            [['vehicle_weight', 'status'], 'integer'],
            [['created_at'], 'safe'],
            [['id', 'vehicle_id', 'station_id'], 'string', 'max' => 300],
            [['unit'], 'string', 'max' => 50],
            [['img_url'], 'string', 'max' => 1000],
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
            'unit' => 'Unit',
            'created_at' => 'Created At',
            'img_url' => 'Img Url',
            'vehicle_id' => 'Vehicle ID',
            'station_id' => 'Station ID',
            'status' => 'Status',
        ];
    }

    public static function statuses()
    {
        return [
            self::STATUS_DONE => 'Done',
            self::STATUS_OVERLOAD => 'Overload',
            self::STATUS_UNDONE => 'Undone'
        ];
    }
}
