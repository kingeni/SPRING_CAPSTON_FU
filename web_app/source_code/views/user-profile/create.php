<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */

$this->title = 'Cập nhật Thông Tin Người Dùng: ' . $username;
$this->params['breadcrumbs'][] = ['label' => 'Tất cả Thông Tin Người Dùng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
