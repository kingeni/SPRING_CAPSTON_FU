<?php

use app\models\VehicleImg;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Vehicle */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vehicle-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'license_plates',
            'name',
            [
                'attribute' => 'expiration_date',
                'label' => 'Expiration Date',
                'value' => function ($model) {
                    return date("d-m-Y", strtotime($model->expiration_date));
                }
            ],
            [
                'attribute' => 'vehicle_weight_id',
                'label' => 'Vehicle Weight',
            ],
            [
                'attribute' => 'user_id',
                'label' => 'Username',
                'value' => function ($model) {
                    return \app\models\User::findOne(['id' => $model->user_id])->username;
                }
            ],
        ],
    ]) ?>
    <h4>Vehicle's Image</h4>
    <?php
    $listVehicleImg = VehicleImg::getVehicleImgByVehicleId($model->id);
    foreach ($listVehicleImg as $item) {
        echo Html::img(Yii::getAlias('@web') . '/' . $item->img_url, ['height' => '200px', 'width' => '200px']) . ' ';
    }
    ?>

</div>
