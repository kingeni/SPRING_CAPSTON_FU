<?php

use app\models\Role;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Role', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'name',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->status == Role::STATUS_NOT_ACTIVE) {
                        return '<span class="badge badge-secondary">Not Active</span>';
                    } else if ($model->status == Role::STATUS_ACTIVE) {
                        return '<span class="badge badge-success">Active</span>';
                    } else if ($model->status == Role::STATUS_DELETED) {
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
