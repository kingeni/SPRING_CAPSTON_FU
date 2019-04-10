<?php

use app\models\Role;
use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $modelProfile app\models\UserProfile */
$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Tất cả Người Dùng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-profile-view">

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
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'username',
                'label' => 'Tên đăng nhập',
            ],
            [
                'attribute' => 'email',
                'label' => 'Email'
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'label' => 'Trạng thái',
                'value' => function ($model) {
                    if ($model->status == User::STATUS_NOT_ACTIVE) {
                        return '<span class="badge badge-secondary">Không hoạt động</span>';
                    } else if ($model->status == User::STATUS_ACTIVE) {
                        return '<span class="badge badge-success">Hoạt động</span>';
                    } else if ($model->status == User::STATUS_DELETED) {
                        return '<span class="badge badge-dark">Đã xóa</span>';
                    } else {
                        return '(not set)';
                    }
                },
            ],
            [
                'attribute' => 'role_id',
                'label' => 'Vai trò',
                'value' => function ($model) {
                    return \app\models\Role::getRolenameById($model->role_id);
                },
            ],
        ],
    ]) ?>
    <?php if ($model->role_id == 2) {
        if ($modelProfile == null) { ?>
            <p>
                <?= Html::a('Cập nhật Thông Tin Người Dùng', ['user-profile/create', 'id' => $model->id, 'username' => $model->username], ['class' => 'btn btn-success']) ?>
            </p>
        <?php } else {
            ?>
            <h3><?= 'Thông tin của ' . $model->username ?></h3>
            <p>
                <?= Html::a('Cập nhật Thông Tin Người Dùng', ['user-profile/update', 'userId' => $modelProfile->user_id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Xóa Thông Tin Người Dùng', ['user-profile/delete', 'userId' => $modelProfile->user_id], [
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
                    [
                        'label' => 'Tên',
                        'attribute' => 'first_name',
                    ],
                    [
                        'label' => 'Họ',
                        'attribute' => 'last_name',
                    ],
                    [
                        'label' => 'Ngày Sinh',
                        'attribute' => 'date_of_birth',
                        'value' => function ($modelProfile) {
                            return date('m-d-Y', strtotime($modelProfile->date_of_birth));
                        }
                    ],
                    [
                        'label' => 'Số điện thoại',
                        'attribute' => 'phone_number',
                    ],
                ],
            ]) ?>
        <?php } ?>

    <?php } ?>
</div>
