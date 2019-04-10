<?php

use kartik\date\DatePicker;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */
?>

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

    <?= $form->field($model, 'gender')->dropDownList(\app\models\UserProfile::genders())->label('Giới tính') ?>

    <?= $form->field($model, 'img_url')->widget(FileInput::classname(), ['options' => ['accept' => 'image/*'],])->label('Avatar') ?>

    <div class="form-group">
        <?= Html::submitButton('Lưu', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
