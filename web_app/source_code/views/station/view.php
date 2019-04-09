<?php

use app\models\Station;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Station */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tất cả Trạm Cân', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="station-view">

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
            ],
//            'id',
//            'name',
//            'phone_number',
//            'address',
//            [
//                'attribute' => 'status',
//                'value' => function ($model) {
//                    if ($model->status == Station::STATUS_NOT_ACTIVE) {
//                        return 'Not Active';
//                    } else if ($model->status == Station::STATUS_ACTIVE) {
//                        return 'Active';
//                    } else if ($model->status == Station::STATUS_DELETED) {
//                        return 'Deleted';
//                    } else {
//                        return '(not set)';
//                    }
//                }
//            ],
        ],
    ]) ?>

</div>
