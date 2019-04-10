<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */

$this->title = User::getUserById($model->user_id)->username;
$this->params['breadcrumbs'][] = ['label' => 'Tất cả Thông Tin Người Dùng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-profile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Cập nhật', ['update', 'userId' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Xóa', ['delete', 'userId' => $model->user_id], [
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
                'label' => 'Avatar',
                'attribute' => 'img_url',
                'value' => '@web/' . $model->img_url,
                'format' => ['image', ['width' => '100', 'height' => '100']],
            ],
//            'user.username',
            [
                'attribute' => 'first_name',
                'label' => 'Tên',
            ],
            [
                'attribute' => 'last_name',
                'label' => 'Họ',
            ],
            [
                'attribute' => 'date_of_birth',
                'label' => 'Ngày sinh',
                'value' => function ($model) {
                    return date('d-m-Y', strtotime($model->date_of_birth));
                }
            ],
            [
                'attribute' => 'phone_number',
                'label' => 'Số điện thoại',
            ],
            [
                'attribute' => 'address',
                'label' => 'Địa chỉ',
            ],
        ],
    ]) ?>

</div>
