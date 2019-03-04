<?php

use app\models\Unit;
use app\models\VehicleWeight;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VehicleWeight */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehicle-weight-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vehicle_weight')->textInput() ?>

    <?= $form->field($model, 'unit')->dropDownList(VehicleWeight::units()) ?>

    <?= $form->field($model, 'status')->dropDownList(VehicleWeight::statuses()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
