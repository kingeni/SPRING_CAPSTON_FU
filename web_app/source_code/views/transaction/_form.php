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

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'id')->textInput($model->isNewRecord ? ['maxlength' => true] : ['maxlength' => true, 'readonly' => 'readonly'])->label('Mã Lượt cân') ?>

            <?= $form->field($model, 'vehicle_weight')->textInput($model->isNewRecord ? [] : ['readonly' => 'readonly'])->label('Tải trọng') ?>

            <?= $form->field($model, 'unit')->dropDownList(VehicleWeight::units(), ['disabled' => !$model->isNewRecord])->label('Đơn vị') ?>

            <?= $form->field($model, 'created_at')->widget(\kartik\datetime\DateTimePicker::className(), [
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd hh:ii'
                ],
                'disabled' => $model->isNewRecord ? false : true
            ])->label('Tạo lúc') ?>

            <?php //$form->field($model, 'img_url')->textInput($model->isNewRecord ? ['maxlength' => true] : ['maxlength' => true, 'readonly' => 'readonly'])  ?>

            <?= $form->field($model, 'vehicle_id')->widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Vehicle::find()->all(), 'id', 'license_plates')
            ])->label('Bảng số Phương tiện') ?>

            <?= $form->field($model, 'station_id')->widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Station::find()->all(), 'id', 'name'),
                'disabled' => $model->isNewRecord ? false : true
            ])->label('Mã Trạm cân') ?>

            <?php if ($model->isNewRecord) {
                echo $form->field($model, 'status')->dropDownList(Transaction::statuses())->label('Trạng thái');
            } ?>

            <div class="form-group">
                <?= Html::submitButton('Lưu', ['class' => 'btn btn-success']) ?>
                <?php if (!$model->isNewRecord) {
                    ?><?php
                    echo Html::a('Hủy', ['cancel', 'id' => $model->id], ['class' => 'btn btn-danger']);
                } ?>
            </div>
        </div>
        <div class="col-sm-6">
            <?php if (!$model->isNewRecord) {
                ?><?php
                echo '<h3>Hình ảnh</h3>';
                echo Html::img(Yii::getAlias('@web') . '/' . $model->img_url, ['height' => '240px', 'width' => '300px']);
            } ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
