<?php

use app\models\Station;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Station */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="station-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(($model->isNewRecord) ? ['maxlength' => true] : ['maxlength' => true, 'readonly' => 'readonly'])->label('Mã Trạm cân') ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Tên Trạm cân') ?>

    <?= $form->field($model, 'phone_number')->widget(MaskedInput::className(),
        [
            'mask' => ['9999999999', '99999999999']
        ]
    )->label('Số điện thoại') ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true])->label('Địa chỉ') ?>

    <?= $form->field($model, 'status')->dropDownList(Station::statuses())->label('Trạng thái') ?>

    <div class="form-group">
        <?= Html::submitButton('Lưu', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
