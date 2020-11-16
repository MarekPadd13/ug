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
    <meta name="yandex-verification" content="f48df379393db69e" />
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="/js/jquery-2.1.4.min.js"></script>

    <script src="/js/jquery.background-video.js"></script>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>


<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
//        'brandLabel' => Yii::$app->name,
        'brandLabel' => Html::img('@web/img/vid-logo.svg'),

        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-light bg-light',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav pt-30'],
        'items' => require __DIR__ . '/_menu.php',
    ]);

//    echo Nav::widget([
//        'options' => ['class' => 'navbar-nav'],
//    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right pt-30'],
        'items' => [


//            Yii::$app->user->isGuest ?
//                ['label' => 'Регистрация', 'url' => ['site/signup']] : ['label' =>''],


            !Yii::$app->user->isGuest ? ['label' => 'Мои сообщения', 'url' => '/all-msg'] : ['label' => '', 'url' => ''],


            Yii::$app->user->isGuest ?
                ['label' => 'Вход', 'url' => ['/site/login']] :
                ['label' => 'выход (' . Yii::$app->user->identity->username.')',
                    'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],


        ]

    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right pt-30'],
        'items' => array_merge(
            [['label' => 'Информационные памятки от юристов', 'url' => '#',
                'items' => array_merge([
                    ['label' => 'Порядок действий при банкротстве застройщика', 'url' => '/site/advice1'],
                    ['label' => 'Рекомендации дольщикам нежилых помещений', 'url' => '/site/advice2'],
                     ['label' => 'Как признать право собственности на объект долевого сроительства в судебном порядке', 'url' => '/site/advice3'],


                ])]]
        ),
    ]);

//    echo Nav::widget([
//        'options' => ['class' => 'navbar-nav navbar-right pt-30'],
//        'items' =>[
//            Yii::$app->user->isGuest ?
//                ['label' => 'Вход', 'url' => ['site/login']] :
//                ['label' => 'выход (' . Yii::$app->user->identity->username.')',
//                    'url' => ['site/logout'], 'linkOptions' => ['data-method' => 'post']],
//        ]
//
//    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?=Breadcrumbs::widget([
         'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
<?php if( Yii::$app->session->hasFlash('success') ): ?>
<div class="alert alert-success alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<?php echo Yii::$app->session->getFlash('success'); ?>
</div>
<?php endif;?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container pull-left">
        <div class="row">
                <div class="col-md-9">
                <p>&copy; Инициативная группа ЖК "Видный город" 2018-<?= date('Y') ?></p>
            </div>
                <div class="col-md-3">
                    <p>in.gr.vg@mail.ru<br/>
                    vg.in.gr@gmail.com</p>
                    <p>
                        <?=Html::a(Html::img('@web/img/instagram.jpg', ['style'=>'width:25px;height:25px']).'/jk_vg_ug', 'https://www.instagram.com/jk_vg_ug/')?>
                    </p>
                </div>
            
        </div>

<!--        <p class="pull-right">--><?//= Yii::powered() ?><!--</p>-->
    </div>
</footer>

<?php $this->endBody() ?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter49202563 = new Ya.Metrika2({
                    id:49202563,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/49202563" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</body>
</html>
<?php $this->endPage() ?>
