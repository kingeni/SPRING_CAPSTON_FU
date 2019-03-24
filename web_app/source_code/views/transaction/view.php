<?php

use app\models\Station;
use app\models\Transaction;
use app\models\User;
use app\models\Vehicle;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$station = Station::findOne($model->station_id);
?>
<div class="transaction-view">

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
        <?= Html::a('PDF Version', ['generate-pdf', 'id' => $model->id], ['class' => 'btn btn-info btn-sm']); ?>
    </p>

    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <label class="col-sm-4 col-form-label" style="text-align: right">Station ID:</label>
                <div class="col-sm-8"><?= $model->station_id ?></div>
            </div>
            <div class="row">
                <label class="col-sm-4 col-form-label" style="text-align: right">Station Name:</label>
                <div class="col-sm-8"><?= $station->name ?></div>
            </div>
            <div class="row">
                <label class="col-sm-4 col-form-label" style="text-align: right">Address:</label>
                <div class="col-sm-8"><?= $station->address ?></div>
            </div>
            <div class="row">
                <label class="col-sm-4 col-form-label" style="text-align: right">Phone Number:</label>
                <div class="col-sm-8"><?= $station->phone_number ?></div>
            </div>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-5">
            <div class="row">
                <label class="col-sm-4 col-form-label" style="text-align: right">Transaction ID:</label>
                <div class="col-sm-8"><?= $model->id ?></div>
            </div>
            <div class="row">
                <label class="col-sm-4 col-form-label" style="text-align: right">Created At:</label>
                <div class="col-sm-8"><?= date('d-m-Y h:i', strtotime($model->created_at)) ?></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6"><h1>VEHICLE'S WEIGHT REPORT</h1></div>
        <div class="col-md-3"></div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8"> <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'vehicle_id',
                        'label' => 'Vehicle ID'
                    ],
                    [
                        'attribute' => 'vehicle_id',
                        'label' => 'Vehicle Name',
                        'value' => function ($model) {
                            return Vehicle::findOne($model->vehicle_id) == null ? '' : Vehicle::findOne($model->vehicle_id)->name;
                        }
                    ],
                    [
                        'attribute' => 'vehicle_id',
                        'label' => 'Expiration Date',
                        'value' => function ($model) {
                            return date('d-m-Y', strtotime(Vehicle::findOne($model->vehicle_id) == null ? '' : Vehicle::findOne($model->vehicle_id)->expiration_date));
                        }
                    ],
                    [
                        'attribute' => 'vehicle_id',
                        'label' => 'Vehicle\'s Owner',
                        'value' => function ($model) {
                            $vehicle = Vehicle::findOne($model->vehicle_id);
                            return $vehicle == null ? '' : User::findOne($vehicle->user_id)->username;
                        }
                    ],
                    'vehicle_weight',
                    'unit',
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
                        'filter' => array('1' => 'Done', '2' => 'Overload', '3' => 'Undone')
                    ],
                ],
            ]) ?></div>
        <div class="col-md-2"></div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8"><h3>Images</h3></div>
        <div class="col-md-2"></div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">    <?php echo Html::img(Yii::getAlias('@web') . '/' . $model->img_url, ['height' => '200px', 'width' => '200px']) . ' '; ?></div>
        <div class="col-md-2"></div>
    </div>

</div>
