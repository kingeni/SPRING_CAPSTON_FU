<?php
/**
 * Created by PhpStorm.
 * User: Huy Ta
 * Date: 2/28/2019
 * Time: 9:26 AM
 */

namespace app\modules\api\controllers;


use app\models\User;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class UserController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionUpdatePassword($userId)
    {
        $oldPassword = Yii::$app->request->post('old_password');
        $newPassword = Yii::$app->request->post('new_password');
        $user = User::findOne(['id' => $userId]);
        if ($user == null) {
            return Json::encode(['status' => false]);
        }
        if ($user->validatePassword($oldPassword)) {
            $user->setPassword($newPassword);
            if ($user->save())
                return Json::encode(['status' => true]);
        }
        return Json::encode(['status' => false]);
    }
}