<?php

use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tất cả Người Dùng';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tạo mới Người Dùng', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'username',
                'label' => 'Tên đăng nhập',
            ],
            [
                'attribute' => 'email',
                'label' => 'Email'
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'label' => 'Trạng thái',
                'value' => function ($model) {
                    if ($model->status == User::STATUS_NOT_ACTIVE) {
                        return '<span class="badge badge-secondary">Không hoạt động</span>';
                    } else if ($model->status == User::STATUS_ACTIVE) {
                        return '<span class="badge badge-success">Hoạt động</span>';
                    } else if ($model->status == User::STATUS_DELETED) {
                        return '<span class="badge badge-dark">Đã xóa</span>';
                    } else {
                        return '(not set)';
                    }
                },
                'filter' => array('1' => 'Không hoạt động', '2' => 'Hoạt động', '3' => 'Đã xóa')
            ],
            [
                'attribute' => 'role_id',
                'label' => 'Vai trò',
                'value' => function ($model) {
                    return \app\models\Role::getRolenameById($model->role_id);
                },
                'filter' => Html::activeDropDownList($searchModel, 'role_id', ArrayHelper::map(\app\models\Role::find()->asArray()->all(), 'id', 'name'), ['class' => 'form-control', 'prompt' => '']),
            ],
//            'username',
//            'email:email',
//            [
//                'attribute' => 'status',
//                'format' => 'raw',
//                'value' => function ($model) {
//                    if ($model->status == User::STATUS_NOT_ACTIVE) {
//                        return '<span class="badge badge-secondary">Not Active</span>';
//                    } else if ($model->status == User::STATUS_ACTIVE) {
//                        return '<span class="badge badge-success">Active</span>';
//                    } else if ($model->status == User::STATUS_DELETED) {
//                        return '<span class="badge badge-dark">Deleted</span>';
//                    } else {
//                        return '(not set)';
//                    }
//                },
//                'filter' => array('1' => 'Not Active', '2' => 'Active', '3' => 'Deleted')
//            ],
//            [
//                'attribute' => 'role_id',
//                'label' => 'Role',
//                'value' => function ($model) {
//                    return \app\models\Role::getRolenameById($model->role_id);
//                },
//                'filter' => Html::activeDropDownList($searchModel, 'role_id', ArrayHelper::map(\app\models\Role::find()->asArray()->all(), 'id', 'name'), ['class' => 'form-control', 'prompt' => '']),
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
