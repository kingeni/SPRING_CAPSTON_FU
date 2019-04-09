<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Đăng Nhập';
?>
<style>
    .center1 {
        position: absolute;
        top: 45%;
        bottom: 0;
        left: 35%;
        right: 0;

        margin: auto;
    }
</style>
<div class="site-login">
    <div class="center">
        <div class="jumbotron">
            <h1>HỆ THỐNG CÂN ĐO, KIỂM TRA TẢI TRỌNG XE</h1>
        </div>
    </div>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <div class="center1">
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Tên đăng nhập</label>
            <div class="col-sm-10">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label(false) ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Mật khẩu</label>
            <div class="col-sm-10">
                <?= $form->field($model, 'password')->passwordInput()->label(false) ?>
            </div>
        </div>
        <p style="color: red"><?= Yii::$app->session->get('alert') ?></p>
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
