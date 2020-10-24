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
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
       // 'brandLabel' =>'Админка',
        'brandUrl' => '/admin',
        'options' => [
            'class' => 'navbar navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
       'items' => [
           ['label' => 'Справочники', 'url' => '#',
           'items' => array_merge([
               ['label' => 'Институты/факультеты', 'url' => '/admin/dict-faculty'],
               ['label' => 'Школы', 'url' => '/admin/dict-school'],
               ['label' => 'Страны', 'url' => '/admin/dict-country'],
               ['label' => 'Регионы РФ', 'url' => '/admin/dict-region'],
               ['label' => 'Города РФ и мира', 'url' => '/admin/dict-city'],
               ['label' => 'Председатели олимпиад', 'url' => '/admin/dict-supervisor'],
               ['label' => 'Классы\курсы', 'url' => '/admin/dict-class-course'],
           ])],
       ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Пользователи', 'url' => '/rbac/default/index',
                'items' => array_merge([
                    ['label' => 'Регистрация новых пользователей', 'url' => '/rbac/user/signup'],
                ])],
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            Yii::$app->user->isGuest ?
                ['label' => 'Вход', 'url' => ['/rbac/user/login']] :
                ['label' => 'Выход (' . Yii::$app->user->identity->username.')',
                    'url' => ['/rbac/user/logout'], 'linkOptions' => ['data-method' => 'post']],
        ]

    ]);
    NavBar::end();
    ?>

    <div class="container" style="margin-top: 165px">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Инициативная группа ЖК "Видный город" <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
