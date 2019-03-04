<?php

use app\models\Station;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\StationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="station-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Station', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'phone_number',
            'address',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    if ($model->status == Station::STATUS_NOT_ACTIVE) {
                        return 'Not Active';
                    } else if ($model->status == Station::STATUS_ACTIVE) {
                        return 'Active';
                    } else if ($model->status == Station::STATUS_DELETED) {
                        return 'Deleted';
                    } else {
                        return '(not set)';
                    }
                },
                'filter' => array('1' => 'Not Active', '2' => 'Active', '3' => 'Deleted'),
                'enableSorting' => false
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
