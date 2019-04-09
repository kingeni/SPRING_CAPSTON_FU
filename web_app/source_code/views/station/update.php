<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Station */

$this->title = 'Cập nhật Trạm Cân: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tất cả Trạm Cân', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="station-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
