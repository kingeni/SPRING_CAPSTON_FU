<?php

use app\models\Vehicle;
use app\models\VehicleWeight;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\VehicleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tất cả Phương Tiện';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tạo mới Phương Tiện', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'label' => 'Mã Thẻ'
            ],
            [
                'attribute' => 'license_plates',
                'headerOptions' => ['style' => 'width:10%'],
                'label' => 'Biển số Xe'
            ],
//            [
//                'attribute' => 'name',
//                'label' => 'Tên Xe'
//            ],
//            'id',
//            'license_plates',
//            'name',
            [
                'attribute' => 'expiration_date',
                'label' => 'Ngày hết hạn đăng kiểm',
                'value' => function ($model) {
                    return date('d-m-Y', strtotime($model->expiration_date));
                },
            ],
            [
                'attribute' => 'vehicle_weight_id',
                'label' => 'Loại tải trọng Xe',
                'filter' => VehicleWeight::getListVehicleWeight(),
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
                'filter' => array('1' => 'Không hoạt động', '2' => 'Hoạt động', '3' => 'Đã xóa')
            ],
            //'user_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('Xem', ['view', 'id' => $model->id], ['class' => 'btn btn-warning btn-xs']);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs']);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('Xóa', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-xs',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
