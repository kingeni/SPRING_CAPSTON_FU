<?php

use app\models\Unit;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Unit */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="unit-view">

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
//            'id',
            'name',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    if ($model->status == Unit::STATUS_NOT_ACTIVE) {
                        return 'Not Active';
                    } else if ($model->status == Unit::STATUS_ACTIVE) {
                        return 'Active';
                    } else if ($model->status == Unit::STATUS_DELETED) {
                        return 'Deleted';
                    } else {
                        return '(not set)';
                    }
                }
            ]
        ],
    ]) ?>

</div>
