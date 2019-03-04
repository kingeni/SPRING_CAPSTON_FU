<?php

use app\models\Station;
use app\models\Transaction;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Transaction', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'vehicle_weight',
            'unit',
            'created_at',
            'img_url:url',
            //'vehicle_id',
            //'station_id',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->status == Transaction::STATUS_DONE) {
                        return '<span class="badge badge-success">Done</span>';
                    } else if ($model->status == Transaction::STATUS_OVERLOAD) {
                        return '<span class="badge badge-danger">Overload</span>';
                    } else if ($model->status == Transaction::STATUS_UNDONE) {
                        return '<span class="badge badge-secondary">Undone</span>';
                    } else {
                        return '(not set)';
                    }
                },
                'filter' => array('1' => 'Not Active', '2' => 'Active', '3' => 'Deleted')
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

    var socket = io.connect('//127.0.0.1:3001');
    var url = window.location.origin;

    socket.on('connect', function () {
        console.log('connected');
        socket.on('new_transaction', function (message) {
            console.log(message);
            updateTransactionIndex();
        });
    });
</script>

