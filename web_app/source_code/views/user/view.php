<?php

use app\models\Role;
use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $modelProfile app\models\UserProfile */
$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-profile-view">

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
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    if ($model->status == User::STATUS_NOT_ACTIVE) {
                        return 'Not Active';
                    } else if ($model->status == User::STATUS_ACTIVE) {
                        return 'Active';
                    } else if ($model->status == User::STATUS_DELETED) {
                        return 'Deleted';
                    } else {
                        return '(not set)';
                    }
                }
            ],
            [
                'attribute' => 'role_id',
                'label' => 'Role',
                'value' => function ($model) {
                    return Role::getRolenameById($model->role_id);
                }
            ]
        ],
    ]) ?>
    <?php if ($model->role_id == 2) {
        if ($modelProfile == null) { ?>
            <p>
                <?= Html::a('Create User Profile', ['user-profile/create', 'id' => $model->id, 'username' => $model->username], ['class' => 'btn btn-success']) ?>
            </p>
        <?php } else {
            ?>
            <h3><?= $model->username . '\'s Profile' ?></h3>
            <p>
                <?= Html::a('Update User Profile', ['user-profile/update', 'userId' => $modelProfile->user_id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete User Profile', ['user-profile/delete', 'userId' => $modelProfile->user_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
            <?= DetailView::widget([
                'model' => $modelProfile,
                'attributes' => [
                    [
                        'label' => 'Avatar',
                        'attribute' => 'img_url',
                        'value' => '/' . $modelProfile->img_url,
                        'format' => ['image', ['width' => '100', 'height' => '100']],
                    ],
//            'user.username',
                    'first_name',
                    'last_name',
                    [
                        'attribute' => 'date_of_birth',
                        'value' => function ($modelProfile) {
                            return date('m-d-Y', strtotime($modelProfile->date_of_birth));
                        }
                    ],
                    'phone_number',
                ],
            ]) ?>
        <?php } ?>

    <?php } ?>
</div>
