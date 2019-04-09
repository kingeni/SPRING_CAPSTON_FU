<?php

namespace app\models;

/**
 * This is the model class for table "vehicle".
 *
 * @property string $id
 * @property string $license_plates
 * @property string $name
 * @property string $expiration_date
 * @property string $vehicle_weight_id
 * @property int $status
 * @property int $user_id
 */
class Vehicle extends \yii\db\ActiveRecord
{
    public $img_url;
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

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
            [['id'], 'required', 'message' => 'Vui lòng nhập Mã Thẻ.'],
            [['id'], 'unique', 'message' => 'Mã Thẻ này đã tồn tại.'],
            [['license_plates'], 'required', 'message' => 'Vui lòng nhập Biển Số Xe.'],
            [['license_plates'], 'unique', 'message' => 'Biển Số Xe này đã tồn tại.'],
            [['license_plates'], 'string', 'max' => 100],
            [['name'], 'required', 'message' => 'Vui lòng nhập Tên Xe.'],
            [['expiration_date'], 'required', 'message' => 'Vui lòng nhập Ngày Hết Hạn Đăng Kiểm.'],
            [['vehicle_weight_id'], 'required', 'message' => 'Vui lòng chọn Loại Xe.'],
            [['user_id'], 'required', 'message' => 'Vui lòng chọn Chủ Xe.'],
            [['id', 'license_plates', 'name', 'expiration_date', 'vehicle_weight_id', 'user_id'], 'required'],
            [['expiration_date'], 'safe'],
            ['expiration_date', 'compareDates'],
            [['user_id', 'status'], 'integer'],
            [['id', 'name', 'vehicle_weight_id'], 'string', 'max' => 300],
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
            $this->addError('expiration_date', 'Ngày Hết Hạn Đăng Kiểm phải lớn hơn ' . date("d-m-Y") . '.');
        }
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
