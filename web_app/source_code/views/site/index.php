<?php

/* @var $this yii\web\View */

use app\models\Transaction;
use dosamigos\chartjs\ChartJs;

$this->title = 'VWMS';
$countAllTranLast = Transaction::countAllTranByLastMonth();
$countAllVTranLast = Transaction::countAllVTranByLastMonth();

$pNorTranLast = ($countAllTranLast - $countAllVTranLast) * 100 / $countAllTranLast;
$pNorTranLast = number_format($pNorTranLast, 1, '.', '');

$pVTranLast = $countAllVTranLast * 100 / $countAllTranLast;
$pVTranLast = number_format($pVTranLast, 1, '.', '');

$countAllTran = Transaction::countAllTran();
$countAllVTran = Transaction::countAllVTran();

$pNorTran = ($countAllTran - $countAllVTran) * 100 / $countAllTran;
$pNorTran = number_format($pNorTran, 1, '.', '');

$pVTran = $countAllVTran * 100 / $countAllTran;
$pVTran = number_format($pVTran, 1, '.', '');
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>VEHICLE WEIGHT MEASURING SYSTEM</h1>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-6">
                <h2>All times</h2>
                <?php echo ChartJs::widget([
                    'type' => 'pie',
                    'id' => 'fPie',
                    'options' => [
                        'height' => 200,
                        'width' => 400,
                    ],
                    'data' => [
                        'radius' => "90%",
                        'labels' => ['Violation Transactions', 'Normal Transactions'], // Your labels
                        'datasets' => [
                            [
                                'data' => [$pVTran, $pNorTran], // Your dataset
                                'label' => '',
                                'backgroundColor' => [
                                    '#FF0000',
                                    '#50C878'
                                ],
                            ]
                        ]
                    ],
                ]) ?>
            </div>
            <div class="col-lg-6">
                <h2>Last month</h2>
                <?php echo ChartJs::widget([
                    'type' => 'pie',
                    'id' => 'sPie',
                    'options' => [
                        'height' => 200,
                        'width' => 400,
                    ],
                    'data' => [
                        'radius' => "90%",
                        'labels' => ['Violation Transactions', 'Normal Transactions'], // Your labels
                        'datasets' => [
                            [
                                'data' => [$pVTranLast, $pNorTranLast], // Your dataset
                                'label' => '',
                                'backgroundColor' => [
                                    '#FF0000',
                                    '#50C878'
                                ],
                            ]
                        ]
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>