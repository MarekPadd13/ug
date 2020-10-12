<?php
/**
 * Created by PhpStorm.
 * User: ramil
 * Date: 11.10.2018
 * Time: 23:43
 */

use yii\helpers\Html;
use app\models\UserDod;
use app\models\Dod;
use app\components\DateTimeToChpu;

$this->title = 'Дни открытых дверей';
$this->params['breadcrumbs'][] = $this->title;

?>


<?php
if ($shareDod) {
    $registrationYetShare = UserDod::find()
        ->andWhere(['user_id' => Yii::$app->user->id])
        ->andWhere(['dod_id' => $shareDod->id])
        ->one();
}

?>


<div class="container">
    <div class="row">
        <?php if (isset($shareDod)): ?>
            <div class="col-md-10 col-md-offset-1 dod_share">

                <?php if (Yii::$app->user->can('count_mc')) : ?>
                    <p>Зарегистрировано: <?php echo UserDod::find()->andWhere(['dod_id' => $shareDod->id])->count() ?>
                        <?= Html::a('Провести розыгрыш', ['/site/lottery', 'dod' => $shareDod->id]) ?></p>
                <?php endif ?>
                <h1 align="center"><?= $shareDod->name ?></h1>

                <p><i>Дата проведения: <?= DateTimeToChpu::getDateChpu($shareDod->date_time) ?>
                    </i></p>
                <p><i>Время начала:<?= DateTimeToChpu::getTimeChpu($shareDod->date_time) ?></i></p>
                <p>Адрес: <?= $shareDod->address;
                    if ($shareDod->aud_number) {
                        echo ', аудитория №' . $shareDod->aud_number;
                    }
                    ?></p>
                <?= $shareDod->description ?>
                <center>
                    <?php if (Yii::$app->user->isGuest) : ?>
                        <?= Html::a('Зарегистрироваться', ['registration-on-dod', 'id' => $shareDod->id],
                            ['class' => 'btn btn-lg btn-bd-primary mb-3 mb-md-0 mr-md-3']); ?>
                    <?php elseif (!($registrationYetShare === null)) : ?>
                        <?= Html::a('Отказаться от регистрации', ['delete-registration', 'id' => $shareDod->id],
                            ['class' => 'btn btn-lg btn-bd-primary mb-3 mb-md-0 mr-md-3'],
                            ['data' => ['confirm' => 'Вы действительно хотите удалить?', 'method' => 'POST']]); ?>

                    <?php else : ?>
                        <?= Html::a('Зарегистрироваться', ['registration-on-dod-user', 'id' => $shareDod->id],
                            ['class' => 'btn btn-lg btn-bd-primary mb-3 mb-md-0 mr-md-3']); ?>

                    <?php endif ?>

                </center>
            </div>
        <?php endif ?>

    </div>

    <?php
    if ($dod->count()):?>
        <?php

        $c = 0;
        $b = 6;

        echo '<h2>Дни открытых дверей в институтах и факультетах МПГУ:</h2>';

        foreach ($dod->each() as $faculty_dod) {
            if ($c % 3 == 0) {
                echo '<div class="row">';
            } ?>
            <div class="col-md-4">
                <div class="dod-panel <?php
                if ($b % 6 == 0) {

                    echo 'orange';
                } elseif ($b % 6 == 1) {
                    echo 'red';
                } elseif ($b % 6 == 2) {
                    echo 'green';
                } elseif ($b % 6 == 3) {
                    echo 'purple';
                } elseif ($b % 6 == 4) {
                    echo 'blue';
                } else {
                    echo 'sky';
                }
                ?>">
                    <?php if (Yii::$app->user->can('count_mc')) : ?>
                        <p>
                            Зарегистрировано: <?php echo UserDod::find()->andWhere(['dod_id' => $faculty_dod->id])->count() ?> </p>
                    <?php endif ?>
                    <h3><?= $faculty_dod->name ?></h3>
                    <p><i>Дата проведения: <?php echo DateTimeToChpu::getDateChpu($faculty_dod->date_time) ?></i></p>
                    <p><i>Время начала: <?php echo DateTimeToChpu::getTimeChpu($faculty_dod->date_time) ?></i></p>
                    <p>Адрес: <?= $faculty_dod->address; ?></p>
                    <?php if ($faculty_dod->aud_number) : ?>
                        <p><?= 'Аудитория №' . $faculty_dod->aud_number; ?></p>

                    <?php endif ?>

                    <?php if (Yii::$app->user->isGuest) : ?>
                    <p>
                        <?= Html::a('Зарегистрироваться', ['registration-on-dod', 'id' => $faculty_dod->id], ['class' => '']); ?>
                        <?php elseif (UserDod::find()
                            ->andWhere(['user_id' => Yii::$app->user->id])
                            ->andWhere(['in', 'dod_id', Dod::find()->select('id')->andWhere(['id' => $faculty_dod->id])])
                            ->one()) : ?>
                            <?= Html::a('Отказаться от регистрации', ['delete-registration-faculty-dod', 'id' => $faculty_dod->id], ['class' => ''], ['data' => ['confirm' => 'Вы действительно хотите удалить?', 'method' => 'POST']]); ?>

                        <?php else : ?>
                            <?= Html::a('Зарегистрироваться', ['registration-on-dod-user', 'id' => $faculty_dod->id], ['class' => '']); ?>

                        <?php endif ?>
                    </p>
                </div>
            </div>
            <?php
            if ($c % 3 == 2) {
                echo "</div>";
            }

            $c++;
            $b++;
        }
        ?>

    <?php else : ?>
        <p>На данный момент все Дни открытых дверей прошли.</p>

    <?php endif ?>


</div>
