<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicle".
 *
 * @property string $id
 * @property string $license_plates
 * @property string $name
 * @property string $expiration_date
 * @property string $vehicle_weight_id
 * @property int $user_id
 */
class Vehicle extends \yii\db\ActiveRecord
{
    public $img_url;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'license_plates', 'name', 'expiration_date', 'vehicle_weight_id', 'user_id'], 'required'],
            [['expiration_date'], 'safe'],
            ['expiration_date', 'compareDates'],
            [['user_id'], 'integer'],
            [['id', 'name', 'vehicle_weight_id'], 'string', 'max' => 300],
            [['license_plates'], 'string', 'max' => 100],
            [['license_plates'], 'unique'],
            [['id'], 'unique'],
            [['img_url'], 'file', 'maxFiles' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'license_plates' => 'License Plates',
            'name' => 'Name',
            'expiration_date' => 'Expiration Date',
            'vehicle_weight_id' => 'Vehicle Weight ID',
            'user_id' => 'User ID',
            'img_url' => 'Images of Vehicle',
        ];
    }

    public function compareDates()
    {
        $expiration_date = date("Y-m-d", strtotime($this->expiration_date));
        $current_date = date("Y-m-d");
        if (!$this->hasErrors() && $expiration_date < $current_date) {
            $this->addError('expiration_date', 'Expiration Date must be greater than ' . date("d-m-Y") . '.');
        }
    }
}
