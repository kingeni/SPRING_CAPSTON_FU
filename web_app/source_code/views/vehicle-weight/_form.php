<?php

use app\models\Unit;
use app\models\VehicleWeight;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VehicleWeight */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehicle-weight-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(($model->isNewRecord) ? ['maxlength' => true] : ['maxlength' => true, 'readonly' => 'readonly'])->label('Mã Loại xe') ?>

    <?= $form->field($model, 'vehicle_weight')->textInput(($model->isNewRecord) ? [] : ['readonly' => 'readonly'])->label('Tải trọng') ?>

    <?= $form->field($model, 'unit')->dropDownList(VehicleWeight::units(), ($model->isNewRecord) ? [] : ['readonly' => 'readonly'])->label('Đơn vị') ?>

    <?= $form->field($model, 'status')->dropDownList(VehicleWeight::statuses())->label('Trạng thái') ?>

    <div class="form-group">
        <?= Html::submitButton('Lưu', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
