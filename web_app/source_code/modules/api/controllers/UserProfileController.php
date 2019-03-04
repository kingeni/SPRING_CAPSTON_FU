<?php
/**
 * Created by PhpStorm.
 * User: Huy Ta
 * Date: 2/28/2019
 * Time: 8:55 AM
 */

namespace app\modules\api\controllers;


use app\models\User;
use app\models\UserProfile;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class UserProfileController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionUpdateUserProfile($userId)
    {
        $userProfile = UserProfile::findOne(['user_id' => $userId]);
        unlink($userProfile->img_url);

        $user = User::findOne(['id' => $userId]);
        if ($userProfile == null && $user == null) {
            Json::encode(['status' => false]);
        }
        $user->email = Yii::$app->request->post('email');

        $userProfile->first_name = Yii::$app->request->post('first_name');
        $userProfile->last_name = Yii::$app->request->post('last_name');
        $userProfile->gender = Yii::$app->request->post('gender');
        $userProfile->date_of_birth = Yii::$app->request->post('date_of_birth');

        //convert image
        $imgBase64 = Yii::$app->request->post('img');
        $imgUrl = 'data/user_profile/' . $userId . '.jpg';
        $file = fopen($imgUrl, 'wb');
        fwrite($file, base64_decode($imgBase64));
        fclose($file);

        $userProfile->img_url = $imgUrl;
        if ($user->validate() && $user->save() && $userProfile->validate() && $userProfile->save()) {
            return Json::encode(['status' => true]);
        }
        return Json::encode(['status' => false]);
    }
}