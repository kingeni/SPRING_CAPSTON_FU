<?php

use app\models\Unit;
use app\models\VehicleWeight;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VehicleWeight */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vehicle Weights', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vehicle-weight-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'vehicle_weight',
            [
                'attribute' => 'unit_id',
                'label' => 'Unit',
                'value' => function ($model) {
                    return Unit::getUnitNameById($model->unit_id);
                }
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    if ($model->status == VehicleWeight::STATUS_NOT_ACTIVE) {
                        return 'Not Active';
                    } else if ($model->status == VehicleWeight::STATUS_ACTIVE) {
                        return 'Active';
                    } else if ($model->status == VehicleWeight::STATUS_DELETED) {
                        return 'Deleted';
                    } else {
                        return '(not set)';
                    }
                }
            ],
        ],
    ]) ?>

</div>
