<?php

use app\models\Vehicle;
use app\models\VehicleImg;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Vehicle */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tất cả Phương Tiện', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vehicle-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Xóa', ['delete', 'id' => $model->id], [
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
            [
                'attribute' => 'id',
                'label' => 'Mã Xe'
            ],
            [
                'attribute' => 'license_plates',
                'label' => 'Biển số Xe'
            ],
            [
                'attribute' => 'name',
                'label' => 'Tên Xe'
            ],
//            'id',
//            'license_plates',
//            'name',
            [
                'attribute' => 'expiration_date',
                'label' => 'Ngày hết hạn đăng kiểm',
                'value' => function ($model) {
                    return date("d-m-Y", strtotime($model->expiration_date));
                }
            ],
            [
                'attribute' => 'vehicle_weight_id',
                'label' => 'Loại tải trọng Xe',
            ],
            [
                'attribute' => 'user_id',
                'label' => 'Chủ xe',
                'value' => function ($model) {
                    return \app\models\User::findOne(['id' => $model->user_id])->username;
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'label' => 'Trạng thái',
                'value' => function ($model) {
                    if ($model->status == Vehicle::STATUS_NOT_ACTIVE) {
                        return '<span class="badge badge-secondary">Không hoạt động</span>';
                    } else if ($model->status == Vehicle::STATUS_ACTIVE) {
                        return '<span class="badge badge-success">Hoạt động</span>';
                    } else if ($model->status == Vehicle::STATUS_DELETED) {
                        return '<span class="badge badge-dark">Đã xóa</span>';
                    } else {
                        return '(not set)';
                    }
                },
            ],
        ],
    ]) ?>

    <?php
    $listVehicleImg = VehicleImg::getVehicleImgByVehicleId($model->id);
    if (count($listVehicleImg) > 0) { ?>    <h4>Hình ảnh Xe</h4><?php
        foreach ($listVehicleImg as $item) {
            echo Html::img(Yii::getAlias('@web') . '/' . $item->img_url, ['height' => '240px', 'width' => '300px']) . ' ';
        }
    }
    ?>

</div>
