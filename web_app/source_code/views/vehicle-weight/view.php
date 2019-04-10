<?php

use app\models\Unit;
use app\models\VehicleWeight;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VehicleWeight */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tất cả Loại tải trọng Xe', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vehicle-weight-view">

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
//            'id',
//            'vehicle_weight',
//            'unit',
//            [
//                'attribute' => 'status',
//                'value' => function ($model) {
//                    if ($model->status == VehicleWeight::STATUS_NOT_ACTIVE) {
//                        return 'Not Active';
//                    } else if ($model->status == VehicleWeight::STATUS_ACTIVE) {
//                        return 'Active';
//                    } else if ($model->status == VehicleWeight::STATUS_DELETED) {
//                        return 'Deleted';
//                    } else {
//                        return '(not set)';
//                    }
//                }
//            ],
            [
                'attribute' => 'id',
                'label' => 'Mã Loại xe',
            ],
            [
                'attribute' => 'vehicle_weight',
                'label' => 'Tải trọng',
            ],
            [
                'attribute' => 'unit',
                'label' => 'Đơn vị',
            ],
//            'id',
//            'vehicle_weight',
//            'unit',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'label' => 'Trạng thái',
                'value' => function ($model) {
                    if ($model->status == VehicleWeight::STATUS_NOT_ACTIVE) {
                        return '<span class="badge badge-secondary">Không hoạt động</span>';
                    } else if ($model->status == VehicleWeight::STATUS_ACTIVE) {
                        return '<span class="badge badge-success">Hoạt động</span>';
                    } else if ($model->status == VehicleWeight::STATUS_DELETED) {
                        return '<span class="badge badge-dark">Đã xóa</span>';
                    } else {
                        return '(not set)';
                    }
                },
            ],
        ],
    ]) ?>

</div>
