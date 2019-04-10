<?php

use app\models\UserProfile;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */

$this->title = 'Cập nhật Thông Tin Người Dùng: ' . $model->first_name . ' ' . $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Tất cả Thông Tin Người Dùng', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->first_name . ' ' . $model->last_name, 'url' => ['view', 'userId' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Cập nhật';

$urlExploded = explode('/', $model->img_url);
$nameSize[] = ['caption' => end($urlExploded), 'size' => filesize($model->img_url)];
?>
<div class="user-profile-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-profile-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true])->label('Tên') ?>

        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true])->label('Họ') ?>

        <?= $form->field($model, 'date_of_birth')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter Birthday ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd-mm-yyyy'
            ]
        ])->label('Ngày sinh') ?>

        <?= $form->field($model, 'phone_number')->widget(MaskedInput::className(),
            [
                'mask' => ['9999999999', '99999999999']
            ])->label('Số điện thoại') ?>

        <?= $form->field($model, 'address')->textInput(['maxlength' => true])->label('Địa chỉ') ?>

        <?= $form->field($model, 'gender')->dropDownList(UserProfile::genders())->label('Giới tính') ?>

        <?= $form->field($model, 'img_url')->widget(FileInput::classname(), [
            'options' => [
                'accept' => 'image/*',
            ],
            'pluginOptions' => [
                'showUpload' => false,
                'initialPreview' => $model->img_url != null ? Yii::getAlias('@web') . '/' . $model->img_url : '',
                'initialPreviewAsData' => true,
                'initialCaption' => "1 files selected",
                'initialPreviewConfig' => $nameSize,
                'fileActionSettings' => [
                    'showZoom' => true,
                    'showRemove' => false,
                ],
            ],
        ])->label('Avatar') ?>

        <div class="form-group">
            <?= Html::submitButton('Lưu', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
