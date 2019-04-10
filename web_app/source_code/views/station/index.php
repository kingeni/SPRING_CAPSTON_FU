<?php

use app\models\Station;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\StationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tất cả Trạm Cân';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="station-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tạo mới Trạm Cân', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'headerOptions' => ['style' => 'width:10%'],
                'label' => 'Mã Trạm cân',
            ],
            [
                'attribute' => 'name',
                'label' => 'Tên Trạm cân',
            ],
            [
                'attribute' => 'phone_number',
                'label' => 'Số điện thoại',
            ],
            [
                'attribute' => 'address',
                'label' => 'Địa chỉ',
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'label' => 'Trạng thái',
                'value' => function ($model) {
                    if ($model->status == Station::STATUS_NOT_ACTIVE) {
                        return '<span class="badge badge-secondary">Không hoạt động</span>';
                    } else if ($model->status == Station::STATUS_ACTIVE) {
                        return '<span class="badge badge-success">Hoạt động</span>';
                    } else if ($model->status == Station::STATUS_DELETED) {
                        return '<span class="badge badge-dark">Đã xóa</span>';
                    } else {
                        return '(not set)';
                    }
                },
                'filter' => array('1' => 'Không hoạt động', '2' => 'Hoạt động', '3' => 'Đã xóa')
            ],
//            'id',
//            'name',
//            'phone_number',
//            'address',
//            [
//                'attribute' => 'status',
//                'format' => 'raw',
//                'value' => function ($model) {
//                    if ($model->status == Station::STATUS_NOT_ACTIVE) {
//                        return '<span class="badge badge-secondary">Not Active</span>';
//                    } else if ($model->status == Station::STATUS_ACTIVE) {
//                        return '<span class="badge badge-success">Active</span>';
//                    } else if ($model->status == Station::STATUS_DELETED) {
//                        return 'Deleted';
//                    } else {
//                        return '(not set)';
//                    }
//                },
//                'filter' => array('1' => 'Not Active', '2' => 'Active', '3' => 'Deleted')
//            ],
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
