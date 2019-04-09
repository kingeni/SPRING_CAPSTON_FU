<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Vehicle */

$this->title = 'Tạo mới Phương Tiện';
$this->params['breadcrumbs'][] = ['label' => 'Tất cả Phương Tiện', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
