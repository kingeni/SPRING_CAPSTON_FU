<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */

$this->title = User::getUserById($model->user_id)->username;
$this->params['breadcrumbs'][] = ['label' => 'User Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-profile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'userId' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'userId' => $model->user_id], [
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
                'value' => '/' . $model->img_url,
                'format' => ['image', ['width' => '100', 'height' => '100']],
            ],
//            'user.username',
            'first_name',
            'last_name',
            [
                'attribute' => 'date_of_birth',
                'value' => function ($model) {
                    return date('d-m-Y', strtotime($model->date_of_birth));
                }
            ],
            'phone_number',
        ],
    ]) ?>

</div>
