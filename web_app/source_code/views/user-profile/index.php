<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tất cả Thông Tin Người Dùng';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user_id',
                'label' => 'Tên đăng nhập',
                'value' => 'user.username',
                'headerOptions' => ['style' => 'width:10%'],
            ],
//            'user_id',
            [
                'attribute' => 'first_name',
                'label' => 'Tên',
                'headerOptions' => ['style' => 'width:10%'],
            ],
            [
                'attribute' => 'last_name',
                'label' => 'Họ',
                'headerOptions' => ['style' => 'width:10%'],
            ],

//            'date_of_birth',
            [
                'attribute' => 'phone_number',
                'label' => 'Số điện thoại',
            ],
            [
                'attribute' => 'address',
                'label' => 'Địa chỉ',
            ],
            //'img_url:url',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('Xem', ['view', 'userId' => $model->user_id], ['class' => 'btn btn-warning btn-xs']);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('Cập nhật', ['update', 'userId' => $model->user_id], ['class' => 'btn btn-primary btn-xs']);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('Xóa', ['delete', 'userId' => $model->user_id], [
                            'class' => 'btn btn-danger btn-xs',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ]
    ]); ?>
</div>
