<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '';
?>
<link href='https://fonts.googleapis.com/css?family=Aldrich' rel='stylesheet'>
<style>
    .center {
        font-family: 'Aldrich';
        font-size: 22px;
        text-align: center;
    }


</style>
<div class="site-login">
    <div class="center">
        <h1>Welcome</h1>
        <h3>to</h3>
        <h1>Vehicle Measuring Weight System</h1>
        <p>Please fill out the following fields to login:</p>
    </div>
    <div style="width:80%;margin-left: 35%">
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>
        <p style="color: red"><?= Yii::$app->session->get('alert') ?></p>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
