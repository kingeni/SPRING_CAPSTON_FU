<?php

use app\models\Transaction;
use app\models\VehicleWeight;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput($model->isNewRecord ? ['maxlength' => true] : ['maxlength' => true, 'readonly' => 'readonly']) ?>

    <?= $form->field($model, 'vehicle_weight')->textInput($model->isNewRecord ? [] : ['readonly' => 'readonly']) ?>

    <?= $form->field($model, 'unit')->dropDownList(VehicleWeight::units(), ['disabled' => !$model->isNewRecord]) ?>

    <?= $form->field($model, 'created_at')->widget(\kartik\datetime\DateTimePicker::className(), [
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii'
        ],
        'disabled' => $model->isNewRecord ? false : true
    ]) ?>

    <?= $form->field($model, 'img_url')->textInput($model->isNewRecord ? ['maxlength' => true] : ['maxlength' => true, 'readonly' => 'readonly']) ?>

    <?= $form->field($model, 'vehicle_id')->widget(\kartik\select2\Select2::className(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\Vehicle::find()->all(), 'id', 'license_plates')
    ])->label('Vehicle\'s Plate Licenses') ?>

    <?= $form->field($model, 'station_id')->widget(\kartik\select2\Select2::className(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\Station::find()->all(), 'id', 'name'),
        'disabled' => $model->isNewRecord ? false : true
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList(Transaction::statuses()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if (!$model->isNewRecord) {
        ?><?php
        echo '<h3>Image</h3>';
        echo Html::img(Yii::getAlias('@web') . '/' . $model->img_url, ['height' => '240px', 'width' => '300px']);
    } ?>
</div>
