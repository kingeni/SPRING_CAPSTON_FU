<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property string $id
 * @property int $vehicle_weight
 * @property int $unit_id
 * @property string $created_at
 * @property string $img_url
 * @property string $vehicle_id
 * @property string $station_id
 * @property int $is_read
 * @property int $status
 */
class Transaction extends \yii\db\ActiveRecord
{
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
            [['id', 'vehicle_weight', 'unit_id', 'created_at', 'img_url', 'vehicle_id', 'station_id', 'status'], 'required'],
            [['vehicle_weight', 'unit_id', 'status'], 'integer'],
            [['created_at'], 'safe'],
            [['id', 'vehicle_id', 'station_id'], 'string', 'max' => 300],
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
            'unit_id' => 'Unit ID',
            'created_at' => 'Created At',
            'img_url' => 'Img Url',
            'vehicle_id' => 'Vehicle ID',
            'station_id' => 'Station ID',
            'status' => 'Status',
        ];
    }
}
