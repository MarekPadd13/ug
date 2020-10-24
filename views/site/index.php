<?php

use yii\helpers\Html;
use app\models\RefProblems;
use app\models\RefAnswer;
use app\models\RefMembers;
use app\models\RefProblemsUser;
use app\models\RefAnswerUser;
use app\models\Profiles;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\RefKomments;

/* @var $this yii\web\View */

$this->title = 'Сайт инициативной группы ЖК "Видный город"'; ?>

<?php
$problems_array = ArrayHelper::map(RefProblems::find()->all(), 'id', 'name');
?>



<?php if (!\Yii::$app->user->isGuest) { ?>
    <div class="row mb-30">
        <div class="col-md-2" align="center">
            <?php echo Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus-sign']), ['profile']); ?>
            <br>
            <?php echo Html::a('Заполнить профиль', ['profile']); ?>
        </div>
        <!--        <div class="col-md-2" align="center">-->
        <!--            --><?php //echo Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-question-sign']), ['my-question']); ?>
        <!--            <br>-->
        <!--            --><?php //echo Html::a('Задать вопрос', ['my-question']); ?>
        <!---->
        <!--        </div>-->


        <?php if (Yii::$app->user->can('chief')) { ?>
            <div class="col-md-2" align="center">
                <?php echo Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-user']), ['interest-bearer-confirm']); ?>
                <br>
                <?php echo Html::a('Подтвердить дольщика', ['interest-bearer-confirm']); ?>

            </div>
        <?php } ?>

        <?php if (Yii::$app->user->can('moderation')) { ?>
            <div class="col-md-2" align="center">
                <?php echo Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-cog']), ['/moderation']); ?>
                <br>
                <?php echo Html::a('Управление и модерация', ['/moderation']); ?>

            </div>
        <?php } ?>

        <!--        --><?php
        //        $profiles = Profiles::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
        //        if ($no_voiting_answer) {
        //            $answer_profile = Profiles::find()->andWhere(['user_id' => $no_voiting_answer->author_id])->one();
        //
        //        }

        ?>

        <!--        --><?php //if (isset($profiles)) { ?>
        <!--            <div class="col-md-2" align="center">-->
        <!--                --><?php //echo Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-exclamation-sign']), ['all-problems']); ?>
        <!--                <br>-->
        <!--                --><?php //echo Html::a('Проблемы и решения 1.0' . Html::tag('sup', 'β'), ['all-problems']); ?>
        <!---->
        <!--            </div>-->
        <!---->
        <!--        --><?php //} ?>

    </div>
<?php } ?>

</div>

<div class="container-fluid width300">


<div class="row">

    <?php if (!Yii::$app->user->id) { ?>
        <h3 align="center" class="pt-100 color-white">Cайт инициативной группы ЖК "Видный город"</h3>
    <?php } ?>
</div>

<?php if (Yii::$app->user->isGuest) { ?>
    <div class="row">
        <div class="col-md-2 col-md-offset-5" align="center"><a align="center" class="btn btn-primary btn-lg"
                                                                href="login"
                                                                role="button">Присоединиться</a></div>
    </div>
<?php } ?>

</div>

<div class="container">

<div class="row">

    <div class="mt-30 col-md-2"
         align="center">
        <?= Html::a(Html::img('@web/img/docs.png') . '<br/>Документы', 'site/documents') ?><br/>
    </div>

    <div class="col-md-2 mt-30" align="center">
        <?= Html::a(Html::img('@web/img/carpooling.png') . '<br/>Довезу до ЖК', 'trip') ?>

    </div>
    <div class="col-md-2 mt-30" align="center">
        <?= Html::a(Html::img('@web/img/cctv.png') . '<br/>Онлайн-трансляция', 'stream') ?>

    </div>
    <div class="col-md-2 mt-30" align="center">
        <?= Html::a(Html::img('@web/img/crane50.png') . '<br/>Ход строительства', 'house-image/index') ?>

    </div>
    <div class="col-md-2 mt-30" align="center">
        <?= Html::a(Html::img('@web/img/links.png') . '<br/>Полезные ссылки', 'links') ?>

    </div>

    <div class="col-md-2 mt-30" align="center">
        <?= Html::a(Html::img('@web/img/vote.png') . '<br/>Текущие голосования и опросы', 'actual-vote') ?>

    </div>

</div>
<div class="row">
    <div class="col-md-12 visible-lg pt-30" align="center">
        <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/7BSgiktc60w?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe> -->
    </div>
</div>


<?php if ($hot_news){ ?>
<div class="container">
    <div class="row pt-30">
        <div class="col-md-12">
            <h3>Новости</h3>
        </div>
    </div>
    <?php } ?>


    <?php $c = 0; ?>


    <?php foreach ($hot_news as $hot_news_all) { ?>
        <?php if ($c % 3 == 0) { ?>
            <div class="row p-30">
        <?php } ?>
        <div class="col-md-4">
            <h4><?php echo Html::a($hot_news_all->h1, ['news', 'id' => $hot_news_all->id]); ?></h4>
            <p><?php echo $hot_news_all->description; ?></p>

            <?php $date = strtotime($hot_news_all->date_of_publication);
            $month = ["01" => "января", "02" => "февраля", "03" => "марта", "04" => "апреля", "05" => "мая", "06" => "июня", "07" => "июля", "08" => "августа",
                "09" => "сентября", "10" => "октября", "11" => "ноября", "12" => "декабря"];
            $dt = \Yii::$app->formatter->asDate($date, 'php:d') . ' ' . $month[Yii::$app->formatter->asDate($date, 'php:m')] . ' ' . \Yii::$app->formatter->asDate($date, 'php:Y'); ?>


            <p><i>Дата публикации: <?php echo $dt; ?></i></p>
        </div>
        <?php if ($c % 3 == 2) { ?>
            </div>
        <?php } ?>
        <?php $c++ ?>
    <?php } ?>
    <div class="row">
        <div class="col-md-12">
            <?php if ($hot_news) { ?>
                <?php echo Html::a('Все новости', 'all-news') ?>
            <?php } ?>
        </div>
    </div>

</div>


<?php
$this->registerJs(<<<JS
$("#answer-details").on("click", "a[data-toggle='modal']", function() {
    var button = $(this);
    $("div" + button.data("modal") + " div.modal-body").load(button.data("remote"));
});
JS
);
?>





<?php Modal::begin(['id' => 'myModal1', 'header' => '<h4 class="modal-title">Голосование. Подробнее о решении проблемы</h4>', 'size' => Modal::SIZE_LARGE]) ?>
<?php
echo "<div id='modalContent1'>";
if (isset($no_voiting_answer)) {
    echo $no_voiting_answer->content;
}
echo "</div>";
Modal::end() ?>

<?php Modal::begin(['id' => 'myModal2', 'header' => '<h4 class="modal-title">Голосование. Суть проблемы</h4>', 'size' => Modal::SIZE_LARGE]) ?>
<?php
echo "<div id='modalContent2'></div>";
Modal::end() ?>

<!--        --><?php //Modal::begin(['id'=>'myModal3', 'header' => '<h4 class="modal-title">Голосование За</h4>',])?>
<!--        --><?php
//        echo "<div id='modalContent3'></div>";
//        Modal::end()?>


﻿<?php Modal::begin(['id' => 'myModal3', 'header' => '<h4 class="modal-title">Голосование За</h4>', 'size' => Modal::SIZE_SMALL]) ?>
<?php Modal::end() ?>


<?php Modal::begin(['id' => 'myModal4', 'header' => '<h4 class="modal-title">Голосование Против</h4>', 'size' => Modal::SIZE_SMALL]) ?>
<?php
echo "<div id='modalContent4'></div>";
Modal::end() ?>

<?php Modal::begin(['id' => 'myModal5', 'header' => '<h4 class="modal-title">Голосование. Суть проблемы</h4>', 'size' => Modal::SIZE_LARGE]) ?>
<?php
echo "<div id='modalContent5'></div>";
Modal::end() ?>

<?php Modal::begin(['id' => 'myModal6', 'header' => '<h4 class="modal-title">Голосование. Добавление своего варианта</h4>', 'size' => Modal::SIZE_LARGE]) ?>
<?php
echo "<div id='modalContent6'></div>";
Modal::end() ?>

<?php Modal::begin(['id' => 'myModal16', 'class' => "modal fide in", 'header' => '<h4 class="modal-title">Комментарий</h4>', 'size' => Modal::SIZE_LARGE]) ?>
<?php
echo "<div id='modalContent16'></div>";
Modal::end() ?>



