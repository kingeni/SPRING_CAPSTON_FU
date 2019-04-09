<?php

use app\models\User;
use app\models\VehicleWeight;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Vehicle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehicle-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true])->label('Mã Thẻ') ?>

    <?= $form->field($model, 'license_plates')->widget(MaskedInput::className(),
        [
            'mask' => ['99A-9999', '99A-99999']
        ]
    )->label('Biển số Xe') ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Tên Xe') ?>

    <?= $form->field($model, 'expiration_date')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Enter Expiration Date ...'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd-mm-yyyy'
        ]
    ])->label('Ngày hết hạn đăng kiểm') ?>

    <?= $form->field($model, 'vehicle_weight_id')->widget(Select2::className(),
        [
            'data' => VehicleWeight::getListVehicleWeight(),
            'options' => ['placeholder' => 'Select a Vehicle Weight ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Loại tải trọng Xe') ?>

    <?= $form->field($model, 'user_id')->widget(Select2::className(),
        [
            'data' => User::getListUser(),
            'options' => ['placeholder' => 'Select an User ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Chủ xe') ?>

    <?= $form->field($model, 'img_url[]')->widget(FileInput::classname(), [
        'options' => [
            'accept' => 'image/*',
            'multiple' => true
        ],
        'pluginOptions' => [
            'showUpload' => false
        ]
    ])->label('Hình ảnh') ?>

    <div class="form-group">
        <?= Html::submitButton('Lưu', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
