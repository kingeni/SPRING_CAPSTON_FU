<?php

use app\models\VehicleWeight;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\VehicleWeightSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vehicle Weights';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-weight-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vehicle Weight', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'vehicle_weight',
            'unit',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->status == VehicleWeight::STATUS_NOT_ACTIVE) {
                        return '<span class="badge badge-secondary">Not Active</span>';
                    } else if ($model->status == VehicleWeight::STATUS_ACTIVE) {
                        return '<span class="badge badge-success">Active</span>';
                    } else if ($model->status == VehicleWeight::STATUS_DELETED) {
                        return '<span class="badge badge-dark">Deleted</span>';
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
