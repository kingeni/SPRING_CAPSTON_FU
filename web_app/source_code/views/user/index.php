<?php

use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            'email:email',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->status == User::STATUS_NOT_ACTIVE) {
                        return '<span class="badge badge-secondary">Not Active</span>';
                    } else if ($model->status == User::STATUS_ACTIVE) {
                        return '<span class="badge badge-success">Active</span>';
                    } else if ($model->status == User::STATUS_DELETED) {
                        return '<span class="badge badge-dark">Deleted</span>';
                    } else {
                        return '(not set)';
                    }
                },
                'filter' => array('1' => 'Not Active', '2' => 'Active', '3' => 'Deleted')
            ],
            [
                'attribute' => 'role_id',
                'label' => 'Role',
                'value' => function ($model) {
                    return \app\models\Role::getRolenameById($model->role_id);
                },
                'filter' => Html::activeDropDownList($searchModel, 'role_id', ArrayHelper::map(\app\models\Role::find()->asArray()->all(), 'id', 'name'), ['class' => 'form-control', 'prompt' => '']),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
