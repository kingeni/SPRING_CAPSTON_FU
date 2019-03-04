<?php

use app\models\VehicleWeight;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vehicle_weight')->textInput() ?>

    <?= $form->field($model, 'unit')->dropDownList(VehicleWeight::units()) ?>

    <?= $form->field($model, 'created_at')->widget(\kartik\datetime\DateTimePicker::className(), [
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii'
        ]
    ]) ?>

    <?= $form->field($model, 'img_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vehicle_id')->widget(\kartik\select2\Select2::className(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\Vehicle::find()->all(), 'id', 'name')
    ]) ?>

    <?= $form->field($model, 'station_id')->widget(\kartik\select2\Select2::className(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\Station::find()->all(), 'id', 'name')
    ]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
