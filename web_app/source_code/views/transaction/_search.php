<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\TransactionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'vehicle_weight') ?>

    <?= $form->field($model, 'unit') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'img_url') ?>

    <?php // echo $form->field($model, 'vehicle_id') ?>

    <?php // echo $form->field($model, 'station_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
