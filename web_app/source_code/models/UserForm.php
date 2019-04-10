<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * Create user form
 */
class UserForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $status;
    public $roleId;

    private $model;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required', 'message' => 'Vui lòng nhập Tên đăng nhập.'],
            ['username', 'unique', 'targetClass' => User::class, 'filter' => function ($query) {
                if (!$this->getModel()->isNewRecord) {
                    $query->andWhere(['not', ['id' => $this->getModel()->id]]);
                }
            }, 'message' => 'Tên đăng nhập này đã tồn tại.'],
            [['username'], 'string', 'min' => 2, 'max' => 255, 'tooShort' => 'Tên đăng nhập bao gồm 2 ký tự trở lên.', 'tooLong' => 'Tên đăng nhập bao gồm 2 ký tự trở lên.'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required', 'message' => 'Vui lòng nhập Email.'],
            ['email', 'email', 'message' => 'Vui lòng nhập Email hợp lệ.'],
            ['email', 'unique', 'targetClass' => User::class, 'filter' => function ($query) {
                if (!$this->getModel()->isNewRecord) {
                    $query->andWhere(['not', ['id' => $this->getModel()->id]]);
                }
            }, 'message' => 'Email này đã tồn tại.'],

            ['password', 'required', 'on' => 'create', 'message' => 'Vui lòng nhập Mật khẩu.'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Mật khẩu bao gồm 6 ký tự trở lên.', 'tooLong' => 'Mật khẩu bao gồm 6 ký tự trở lên.'],

            [['status'], 'integer'],
            ['roleId', 'required'],
        ];
    }

    /**
     * @return User
     */
    public function getModel()
    {
        if (!$this->model) {
            $this->model = new User();
        }
        return $this->model;
    }

    /**
     * @param User $model
     * @return mixed
     */
    public function setModel($model)
    {
        $this->username = $model->username;
        $this->email = $model->email;
        $this->status = $model->status;
        $this->roleId = $model->role_id;
        $this->model = $model;
        return $this->model;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
            'status' => 'Status',
            'password' => 'Password',
            'roleId' => 'Role'
        ];
    }

    /**
     * Signs user up.
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     */
    public function save()
    {
        if ($this->validate()) {
            $model = $this->getModel();
            $isNewRecord = $model->getIsNewRecord();
            $model->username = $this->username;
            $model->email = $this->email;
            $model->status = $this->status;
            if ($this->password) {
                $model->setPassword($this->password);
            }
            $model->role_id = $this->roleId;
            $model->auth_key = Yii::$app->getSecurity()->generateRandomString();
            $model->access_token = Yii::$app->getSecurity()->generateRandomString(40);
            if (!$model->save()) {
                throw new Exception('Model not saved');
            }
            if ($isNewRecord) {

            }
            return !$model->hasErrors();
        }
        return null;
    }
}
