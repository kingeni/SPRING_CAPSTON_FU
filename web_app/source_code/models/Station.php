<?php

namespace app\models;

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
            [['id'], 'required', 'message' => 'Vui lòng nhập Mã Trạm cân.'],
            [['name'], 'required', 'message' => 'Vui lòng nhập Tên Trạm cân.'],
            [['phone_number'], 'required', 'message' => 'Vui lòng nhập Số điện thoại.'],
            [['address',], 'required', 'message' => 'Vui lòng nhập Địa chỉ.'],
            [['status'], 'integer'],
            [['id'], 'string', 'max' => 300],
            [['name'], 'string', 'max' => 500],
            [['phone_number'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 1000],
            [['id'], 'unique', 'message' => 'Mã Trạm cân này đã tồn tại.'],
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
            self::STATUS_NOT_ACTIVE => 'Không hoạt động',
            self::STATUS_ACTIVE => 'Hoạt động',
            self::STATUS_DELETED => 'Đã xóa'
        ];
    }
}
