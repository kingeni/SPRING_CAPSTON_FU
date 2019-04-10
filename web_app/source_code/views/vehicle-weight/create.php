<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VehicleWeight */

$this->title = 'Tạo mới Loại tải trọng Xe';
$this->params['breadcrumbs'][] = ['label' => 'Tất cả Loại tải trọng Xe', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-weight-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
