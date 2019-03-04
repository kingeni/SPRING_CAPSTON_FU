<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "station".
 *
 * @property string $id
 * @property string $name
 * @property string $phone_number
 * @property string $address
 * @property int $status
 */
class Station extends \yii\db\ActiveRecord
{
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'station';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'phone_number', 'address', 'status'], 'required'],
            [['status'], 'integer'],
            [['id'], 'string', 'max' => 300],
            [['name'], 'string', 'max' => 500],
            [['phone_number'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 1000],
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
            'name' => 'Name',
            'phone_number' => 'Phone Number',
            'address' => 'Address',
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
}
