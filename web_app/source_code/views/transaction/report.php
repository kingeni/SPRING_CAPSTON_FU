<?php

use app\models\Station;
use app\models\Vehicle;
use app\models\UserProfile;
use app\models\VehicleWeight;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */
$station = Station::findOne($model->station_id);
$vehicle = Vehicle::findOne($model->vehicle_id);
$userProfile = UserProfile::getUserProfileByUserID($vehicle->user_id);
$vehicleWeight = VehicleWeight::findOne($vehicle->vehicle_weight_id);
$firstName = $userProfile->first_name;
$lastName = $userProfile->last_name;
?>
<div>
    <div style="float: left; width: 50%;">
        <table>
            <tr>
                <td>Mã trạm cân:</td>
                <td><?= $model->station_id ?></td>
            </tr>
            <tr>
                <td>Tên trạm cân:</td>
                <td><?= $station->name ?></td>
            </tr>
            <tr>
                <td>Địa chỉ:</td>
                <td><?= $station->address ?></td>
            </tr>
            <tr>
                <td>Số điện thoại:</td>
                <td><?= $station->phone_number ?></td>
            </tr>
        </table>
    </div>

    <div style="float: right; width: 35%;">
        <table>
            <tr>
                <td>Mã giao dịch:</td>
                <td><?= $model->id ?></td>
            </tr>
            <tr>
                <td>Tạo lúc:</td>
                <td><?= date('d-m-Y h:i', strtotime($model->created_at)) ?></td>
            </tr>
        </table>
    </div>

</div>
<div style="margin-left: 10%;width: 80%">
    <hr>
</div>
<div style="margin-left: 60px; width: 100%;">
    <h1>PHIẾU CÂN KIỂM TRA TẢI TRỌNG XE</h1>
</div>
<div>
    <table>
        <tr>
            <td style="font-weight: bold">Kính gửi:</td>
            <td>Ông/bà <?= ucfirst($userProfile->first_name) . ' ' . ucfirst($userProfile->last_name) ?></td>
            <td>Địa chỉ:</td>
            <td>123123</td>
        </tr>
        <tr>
            <td></td>
            <td>Điện thoại: <?= $userProfile->phone_number ?></td>
        </tr>
        <tr>
            <td></td>
            <td>Là chủ sở hữu phương tiện có biển kiểm soát:</td>
            <td> <?= $vehicle->license_plates ?>.</td>
        </tr>
    </table>
</div>
<br>
<div style="float: left; width: 50%;">
    <p style="font-weight: bold; margin-left: 5px">Thông tin phương tiện</p>
    <table style="padding-top: -10px">
        <tr>
            <td>Tên phương tiện:</td>
            <td><?= $vehicle->name ?></td>
        </tr>
        <tr>
            <td>Loại xe:</td>
            <td><?= $vehicle->vehicle_weight_id ?></td>
        </tr>
        <tr>
            <td>Ngày hết hạn đăng kiểm:</td>
            <td> <?= date('d-m-Y', strtotime($vehicle->expiration_date)) ?></td>
        </tr>
        <tr>
            <td>Tải trọng cho phép:</td>
            <td><?= $vehicleWeight->vehicle_weight . ' ' . $vehicleWeight->unit ?></td>
        </tr>
        <tr>
            <td>Thời gian cân:</td>
            <td><?= date('d-m-Y h:i', strtotime($model->created_at)) ?></td>
        </tr>
    </table>
</div>
<div style="float: left; width: 50%;"><?php echo Html::img(Yii::getAlias('@web') . '/' . $model->img_url, ['height' => '800px', 'width' => '1200px']) . ' '; ?></div>
<br>
<div>
    <p style="font-weight: bold; margin-left: 5px">Kết quả cân được</p>
    <table class="tbl" border="1">
        <tr class="tbl">
            <td class="tbl" align="center">Biển số xe</td>
            <td class="tbl" align="center">Tải trọng cả xe (<?= $model->unit ?>)</td>
            <td class="tbl" align="center">Sai số cho phép (<?= $model->unit ?>)</td>
            <td class="tbl" align="center">Tải trọng trừ sai số (<?= $model->unit ?>)</td>
            <td class="tbl" align="center">Tải trọng cho phép (<?= $model->unit ?>)</td>
            <td class="tbl" align="center">Tải trọng quá tải (<?= $model->unit ?>)</td>
            <td class="tbl" align="center">Kết luận quá tải (%)</td>
        </tr>
        <tr class="tbl">
            <td class="tbl" align="center"><?= $vehicle->license_plates ?></td>
            <td class="tbl" align="right"><?= $model->vehicle_weight ?></td>
            <td class="tbl" align="right"><?= $errorNo = round(($model->vehicle_weight / 100) * 4, 2) ?></td>
            <td class="tbl" align="right"><?= $afterError = $model->vehicle_weight - $errorNo ?></td>
            <td class="tbl" align="right"><?= $vehicleWeight->vehicle_weight ?></td>
            <td class="tbl" align="right"><?php if ($afterError > $vehicleWeight->vehicle_weight) {
                    echo $afterError - $vehicleWeight->vehicle_weight;
                } else {
                    echo "0.00";
                } ?></td>
            <td class="tbl" align="right"><?php if ($afterError > $vehicleWeight->vehicle_weight) {
                    echo $total = round(($afterError - $vehicleWeight->vehicle_weight) / $vehicleWeight->vehicle_weight * 100, 2);
                } else {
                    $total = 0;
                    echo "0.00";
                } ?></td>
        </tr>
    </table>
    <br>
    <p style="font-weight: bold; margin-left: 5px"><?php if ($total > 0) {
            echo "Kết luận: Xe vượt tổng tải trọng cho phép của cầu, đường: " . $total . "%";
        } else {
            echo "Kết luận: Xe đạt đúng tổng tải trọng cho phép của cầu, đường.";
        } ?></td>
    </p>
</div>
<br>
<div style="float: left; width: 50%;">
    <p style="font-weight: bold; font-size: 12px">Người lái xe(chủ xe hoặc người đại diện):</p>
    <p style="font-style: italic; font-size: 11px; margin-left: 20%">(Ký ghi rõ họ tên)</p>
</div>
<div style="float: left; width: 30%; margin-left: 20%">
    <p style="font-weight: bold; font-size: 12px">Người lập phiếu:</p>
    <p style="font-style: italic; font-size: 11px; margin-left: 5%">(Ký ghi rõ họ tên)</p>
</div>



