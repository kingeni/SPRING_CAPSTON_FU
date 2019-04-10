<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "role".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 */
class Role extends \yii\db\ActiveRecord
{
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 100],
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
            'status' => 'Status',
        ];
    }

    public static function roles()
    {
        return ArrayHelper::map(Role::find()->all(), 'id', 'name');
    }

    public static function statuses()
    {
        return [
            self::STATUS_NOT_ACTIVE => 'Không hoạt động',
            self::STATUS_ACTIVE => 'Hoạt động',
            self::STATUS_DELETED => 'Đã xóa'
        ];
    }

    public static function getRolenameById($id)
    {
        return Role::findOne(['id' => $id])->name;
    }
}
