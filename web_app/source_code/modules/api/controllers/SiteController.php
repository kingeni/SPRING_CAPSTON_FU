<?php
/**
 * Created by PhpStorm.
 * User: Huy Ta
 * Date: 2/25/2019
 * Time: 11:11 AM
 */

namespace app\modules\api\controllers;

use app\models\User;
use app\models\UserProfile;
use app\modules\api\models\LoginForm;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class SiteController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionLogin()
    {
        $modelLogin = new LoginForm();
        $modelLogin->username = Yii::$app->request->post('username');
        $modelLogin->password = Yii::$app->request->post('password');

        if ($modelLogin->login()) {
            if (User::findOne(['username' => $modelLogin->user])->role_id == 1) {
                return '{"login":false}';
            } else {
                $userId = User::getUserIdByUsername($modelLogin->username);
                $userProfile = UserProfile::find()->asArray()->where(['user_id' => $userId])->one();
                if ($userProfile != null) {
                    $userProfile['img_url'] = base64_encode(file_get_contents($userProfile['img_url']));
                    $arr[] = array_merge(User::find()->asArray()->where(['id' => $userId])->one(), $userProfile);
                } else {
                    $arr[] = User::findOne(['id' => $userId]);
                }

                return Json::encode($arr);
            }
        } else {
            return Json::encode(['status' => false]);
        }
    }

}