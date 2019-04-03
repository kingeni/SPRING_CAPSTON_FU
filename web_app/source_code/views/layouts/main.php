<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'VWMS',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Trang chủ', 'url' => ['/site/index']],
//            ['label' => 'About', 'url' => ['/site/about']],
            [
                'label' => 'Quản lý Lượt Cân',
                'url' => '/transaction/index'
            ],
            [
                'label' => 'Quản lý Phương Tiện',
                'items' => [
                    ['label' => 'Quản lý Phương Tiện', 'url' => '/vehicle/index'],
                    '<li class="divider"></li>',
                    ['label' => 'Quản lý Loại Xe', 'url' => '/vehicle-weight/index'],
                ],
            ],
            [
                'label' => 'Quản lý Trạm Cân',
                'url' => '/station/index'
            ],
            [
                'label' => 'Quản lý Người Dùng',
                'items' => [
                    ['label' => 'Quản lý Người Dùng', 'url' => '/user/index'],
                    '<li class="divider"></li>',
                    ['label' => 'Quản lý Thông Tin Người Dùng', 'url' => '/user-profile/index'],
                    '<li class="divider"></li>',
                    ['label' => 'Quản lý Vai Trò Người Dùng', 'url' => ['/role/index']],
                ],
            ],
//            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
            ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
