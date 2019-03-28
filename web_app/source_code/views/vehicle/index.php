<?php

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

            'id',
            'license_plates',
            'name',
            [
                'attribute' => 'expiration_date',
                'value' => function ($model) {
                    return date('d-m-Y', strtotime($model->expiration_date));
                },
            ],
            [
                'attribute' => 'vehicle_weight_id',
                'label' => 'Vehicle Weight',
            ],
            //'user_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
