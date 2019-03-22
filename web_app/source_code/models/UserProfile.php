<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property string $first_name
 * @property string $last_name
 * @property string $date_of_birth
 * @property string $phone_number
 * @property double $identity_number
 * @property string $gender
 * @property string $img_url
 * @property string $username
 * @property int $user_id
 */
class UserProfile extends \yii\db\ActiveRecord
{
    const FEMALE = 'Female';
    const MALE = 'Male';
    const UNDIFINED = 'Undifined';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_of_birth', 'username', 'gender'], 'safe'],
            ['date_of_birth', 'compareDates'],
            [['phone_number', 'user_id', 'first_name', 'last_name'], 'required'],
            [['user_id'], 'integer'],
            [['identity_number'], 'double'],
            [['gender'], 'string', 'max' => 100],
            [['first_name', 'last_name'], 'string', 'max' => 300],
            [['phone_number'], 'string', 'max' => 50],
            [['img_url'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'date_of_birth' => 'Date Of Birth',
            'phone_number' => 'Phone Number',
            'identity_number' => 'Identity Number',
            'gender' => 'Gender',
            'img_url' => 'Img Url',
            'user_id' => 'User ID',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function checkAvt($img_url)
    {
        $url = 'data/user_profile/' . $img_url;
        $listUserProfile = UserProfile::findAll(['img_url' => $url]);
        if (count($listUserProfile) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function compareDates()
    {
        $birthday = date("Y-m-d", strtotime($this->date_of_birth));
        $current_date = date("Y-m-d");
        if (!$this->hasErrors() && $birthday > $current_date) {
            $this->addError('date_of_birth', 'Date of birth must be smaller than ' . date("d-m-Y") . '.');
        }
    }

    public static function genders()
    {
        return [
            self::FEMALE => 'Female',
            self::MALE => 'Male',
            self::UNDIFINED => 'Undifined'
        ];
    }

    public static function getUserProfileByUserID($id)
    {
        return UserProfile::findOne(['user_id' => $id]);
    }
}
