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
$this->params['breadcrumbs'][] = ['label' => 'Tất cả Lượt Cân', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$station = Station::findOne($model->station_id);
?>
<div class="transaction-view">

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
        <?= Html::a('Xuất Biên bản', ['generate-pdf', 'id' => $model->id], ['class' => 'btn btn-info btn-sm', 'target' => "_blank"]); ?>
    </p>

    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <label class="col-sm-4 col-form-label" style="text-align: right">Mã Trạm cân:</label>
                <div class="col-sm-8"><?= $model->station_id ?></div>
            </div>
            <div class="row">
                <label class="col-sm-4 col-form-label" style="text-align: right">Tên Trạm cân:</label>
                <div class="col-sm-8"><?= $station->name ?></div>
            </div>
            <div class="row">
                <label class="col-sm-4 col-form-label" style="text-align: right">Địa chỉ:</label>
                <div class="col-sm-8"><?= $station->address ?></div>
            </div>
            <div class="row">
                <label class="col-sm-4 col-form-label" style="text-align: right">Số điện thoại:</label>
                <div class="col-sm-8"><?= $station->phone_number ?></div>
            </div>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-5">
            <div class="row">
                <label class="col-sm-4 col-form-label" style="text-align: right">Mã Lượt cân:</label>
                <div class="col-sm-8"><?= $model->id ?></div>
            </div>
            <div class="row">
                <label class="col-sm-4 col-form-label" style="text-align: right">Tạo lúc:</label>
                <div class="col-sm-8"><?= date('d-m-Y h:i', strtotime($model->created_at)) ?></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10"> <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'vehicle_id',
                        'label' => 'Mã Phương tiện'
                    ],
                    [
                        'attribute' => 'vehicle_id',
                        'label' => 'Tên Phương tiện',
                        'value' => function ($model) {
                            return Vehicle::findOne($model->vehicle_id) == null ? '' : Vehicle::findOne($model->vehicle_id)->name;
                        }
                    ],
                    [
                        'attribute' => 'vehicle_id',
                        'label' => 'Ngày hết hạn',
                        'value' => function ($model) {
                            return date('d-m-Y', strtotime(Vehicle::findOne($model->vehicle_id) == null ? '' : Vehicle::findOne($model->vehicle_id)->expiration_date));
                        }
                    ],
                    [
                        'attribute' => 'vehicle_id',
                        'label' => 'Chủ xe',
                        'value' => function ($model) {
                            $vehicle = Vehicle::findOne($model->vehicle_id);
                            return $vehicle == null ? '' : User::findOne($vehicle->user_id)->username;
                        }
                    ],
                    [
                        'attribute' => 'vehicle_weight',
                        'label' => 'Tải trọng cho phép',
                        'value' => function ($model) {
                            $vehicle = Vehicle::findOne($model->vehicle_id);
                            $vehicleWeight = \app\models\VehicleWeight::findOne($vehicle->vehicle_weight_id);
                            return $vehicleWeight->vehicle_weight . ' ' . $vehicleWeight->unit;
                        }
                    ],
                    [
                        'attribute' => 'vehicle_weight',
                        'label' => 'Tải trọng cân được',
                        'value' => function ($model) {
                            return $model->vehicle_weight . ' ' . $model->unit;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Trạng thái',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->status == Transaction::STATUS_DONE) {
                                return '<span class="badge badge-success">Hoàn Thành</span>';
                            } else if ($model->status == Transaction::STATUS_OVERLOAD) {
                                return '<span class="badge badge-danger">Quá Tải</span>';
                            } else if ($model->status == Transaction::STATUS_UNDONE) {
                                return '<span class="badge badge-secondary">Chưa Hoàn Thành</span>';
                            } else {
                                return '(not set)';
                            }
                        },
                    ],
                ],
            ]) ?></div>
        <div class="col-md-1"></div>
    </div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10"><h3>Hình ảnh</h3></div>
        <div class="col-md-1"></div>
    </div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10"><?php echo Html::img(Yii::getAlias('@web') . '/' . $model->img_url, ['height' => '240px', 'width' => '360px']); ?></div>
        <div class="col-md-1"></div>
    </div>
</div>
