<?php

use app\models\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Cập nhật Người Dùng: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Tất cả Người Dùng', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => User::getUserIdByUsername($model->username)]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-profile-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
