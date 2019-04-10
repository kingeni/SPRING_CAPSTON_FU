<?php

use app\models\Transaction;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tất cả Lượt Cân';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // echo Html::a('Tạo mới Lượt Cân', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'label' => 'Mã Lượt cân',
            ],
            [
                'attribute' => 'vehicle_id',
                'label' => 'Mã Phương tiện',
            ],
            [
                'attribute' => 'vehicle_weight',
                'label' => 'Tải trọng Xe',
                'headerOptions' => ['style' => 'width:5%'],
                'value' => function ($model) {
                    return $model->vehicle_weight . ' ' . $model->unit;
                },
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Tạo lúc',
                'headerOptions' => ['style' => 'width:13%'],
                'value' => function ($model) {
                    return date('h:i d-m-Y', strtotime($model->created_at));
                },
            ],
//            'created_at',
//            'img_url:url',
            [
                'attribute' => 'station_id',
                'label' => 'Mã Trạm cân',
                'headerOptions' => ['style' => 'width:10%'],
            ],
            [
                'attribute' => 'status',
                'label' => 'Trạng thái',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->status == Transaction::STATUS_DONE) {
                        return '<span class="badge badge-success">Đủ Tải</span>';
                    } else if ($model->status == Transaction::STATUS_OVERLOAD) {
                        return '<span class="badge badge-danger">Quá Tải</span>';
                    } else if ($model->status == Transaction::STATUS_UNDONE) {
                        return '<span class="badge badge-secondary">Đang Xử Lý</span>';
                    } else if ($model->status == Transaction::STATUS_CANCEL) {
                        return '<span class="badge badge-secondary">Hủy</span>';
                    } else {
                        return '(not set)';
                    }
                },
                'filter' => array('1' => 'Đủ Tải', '2' => 'Quá Tải', '3' => 'Đang Xử Lý', '4' => 'Hủy')
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('Xem', ['view', 'id' => $model->id], ['class' => 'btn btn-warning btn-xs']);
                    },
                    'update' => function ($url, $model) {
                        if ($model->status == Transaction::STATUS_UNDONE) {
                            return Html::a('Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs']);
                        } else {
                            return '';
                        }

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

<script src='//cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.4/socket.io.min.js'></script>
<script>
    function updateTransactionIndex() {
        $.ajax({
            url: url + '/transaction/update-transaction',
            method: "get",
            success: function (data) {
                $('.transaction-index').replaceWith(data);
            }
        })
    }

    var socket = io.connect('//127.0.0.1:1337');
    var url = window.location.origin;

    socket.on('connect', function () {
        socket.on('update_transaction', function (message) {
            console.log(message);
            updateTransactionIndex();
        });
    });
</script>

