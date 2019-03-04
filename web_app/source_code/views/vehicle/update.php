<?php

use app\models\User;
use app\models\VehicleWeight;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Vehicle */

$this->title = 'Update Vehicle: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$listImgUrl = [];
$listNameSize = [];
if (count($model->img_url) > 0) {
    foreach ($model->img_url as $item) {
        $listImgUrl[] = Yii::getAlias('@web') . '/' . $item;
        $urlExploded = explode('/', $item);
        $listNameSize[] = ['caption' => end($urlExploded), 'size' => filesize($item)];
    }
}

?>
<div class="vehicle-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="vehicle-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'id')->textInput(['maxlength' => true, 'readonly' => true]) ?>

        <?= $form->field($model, 'license_plates')->widget(MaskedInput::className(),
            [
                'mask' => '99A-99999',
                'options' => [
                    'disabled' => true,
                    'class' => 'form-control',
                ]
            ]
        ) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'expiration_date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter Expiration Date ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd-mm-yyyy'
            ]
        ]) ?>

        <?= $form->field($model, 'vehicle_weight_id')->widget(Select2::className(),
            [
                'data' => VehicleWeight::getListVehicleWeight(),
                'options' => ['placeholder' => 'Select a Vehicle Weight ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Vehicle\'s Weight') ?>

        <?= $form->field($model, 'user_id')->widget(Select2::className(),
            [
                'data' => User::getListUser(),
                'options' => ['placeholder' => 'Select an User ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Vehicle\'s Owner') ?>

        <?= $form->field($model, 'img_url[]')->widget(FileInput::classname(), [
            'options' => [
                'accept' => 'image/*',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'showUpload' => false,
                'initialPreview' => $listImgUrl,
                'initialPreviewAsData' => true,
                'initialCaption' => count($listImgUrl) . " files selected",
                'initialPreviewConfig' => $listNameSize,
                'fileActionSettings' => [
                    'showZoom' => true,
                    'showRemove' => false,
                ],
            ],
        ])->label('Vehicle\'s Images') ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
