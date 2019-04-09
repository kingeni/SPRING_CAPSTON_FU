<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Station */

$this->title = 'Tạo mới Trạm Cân';
$this->params['breadcrumbs'][] = ['label' => 'Tất cả Trạm Cân', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="station-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
