<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $email
 * @property string $auth_key
 * @property string $access_token
 * @property int $status
 * @property int $role_id
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'email', 'auth_key', 'access_token', 'status', 'role_id'], 'required'],
            [['status', 'role_id'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['password_hash'], 'string', 'max' => 10000],
            [['email'], 'string', 'max' => 300],
            [['auth_key', 'access_token'], 'string', 'max' => 1000],
            [['username', 'email'], 'unique', 'targetAttribute' => ['username', 'email']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'email' => 'Email',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'status' => 'Status',
            'role_id' => 'Role ID',
        ];
    }

    public static function findIdentity($id)
    {
        return static::find()
            ->andWhere(['id' => $id])
            ->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()
            ->andWhere(['access_token' => $token])
            ->one();
    }

    public static function findByUsername($username)
    {
        return static::find()
            ->andWhere(['username' => $username])
            ->one();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    public static function statuses()
    {
        return [
            self::STATUS_NOT_ACTIVE => 'Không hoạt động',
            self::STATUS_ACTIVE => 'Hoạt động',
            self::STATUS_DELETED => 'Đã xóa'
        ];
    }

    public static function getUserById($id)
    {
        return User::findOne(['id' => $id]);
    }

    public static function getListUser()
    {
        return ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE, 'role_id' => 2])->all(), 'id', 'username');
    }

    public static function getUserIdByUsername($username)
    {
        return User::findOne(['username' => $username])->id;
    }
}
