<?php

use app\models\Station;
use app\models\Transaction;
use yii\helpers\Html;
use yii\grid\GridView;

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
        <?= Html::a('Tạo mới Lượt Cân', ['create'], ['class' => 'btn btn-success']) ?>
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
                'value' => function ($model) {
                    return $model->vehicle_weight . ' ' . $model->unit;
                },
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Tạo lúc',
                'value' => function ($model) {
                    return date('h:i d-m-Y', strtotime($model->created_at));
                },
            ],
//            'created_at',
//            'img_url:url',
            [
                'attribute' => 'station_id',
                'label' => 'Mã Trạm cân',
            ],
            [
                'attribute' => 'status',
                'label' => 'Trạng thái',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->status == Transaction::STATUS_DONE) {
                        return '<span class="badge badge-success">Hoàn Thành</span>';
                    } else if ($model->status == Transaction::STATUS_OVERLOAD) {
                        return '<span class="badge badge-danger">Quá Tải</span>';
                    } else if ($model->status == Transaction::STATUS_UNDONE) {
                        return '<span class="badge badge-secondary">Chưa Hoàn Thành</span>';
                    } else {
                        return '(not set)';
                    }
                },
                'filter' => array('1' => 'Hoàn Thành', '2' => 'Quá Tải', '3' => 'Chưa Hoàn Thành')
            ],

            ['class' => 'yii\grid\ActionColumn'],
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

