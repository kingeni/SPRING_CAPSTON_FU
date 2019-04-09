<?php

use app\models\Role;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tất cả Vai Trò';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //echo Html::a('Tạo mới Vai Trò', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'label' => 'Mã Vai trò',
            ],
            [
                'attribute' => 'name',
                'label' => 'Tên Vai trò',
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'label' => 'Trạng thái',
                'value' => function ($model) {
                    if ($model->status == Role::STATUS_NOT_ACTIVE) {
                        return '<span class="badge badge-secondary">Không hoạt động</span>';
                    } else if ($model->status == Role::STATUS_ACTIVE) {
                        return '<span class="badge badge-success">Hoạt động</span>';
                    } else if ($model->status == Role::STATUS_DELETED) {
                        return '<span class="badge badge-dark">Đã xóa</span>';
                    } else {
                        return '(not set)';
                    }
                },
                'filter' => array('1' => 'Không hoạt động', '2' => 'Hoạt động', '3' => 'Đã xóa')
            ],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
