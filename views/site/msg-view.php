<?php

use yii\helpers\Html;


/**
 * @var $letter
 * @var $currentTheme
 */

$allAnswer = \app\modules\sending\models\DictPollAnswers::getAllItems();
$userName = \app\models\Profiles::getNameAndPatronymic();

if (!Yii::$app->user->isGuest) {
    $this->title = $currentTheme;
    $this->params['breadcrumbs'][] = ['label' => 'Мои сообщения', 'url' => ['/all-msg']];
    $this->params['breadcrumbs'][] = $this->title;
}

echo Html::decode($letter);


if (!Yii::$app->user->isGuest) {
    echo Html::a('Вернуться к списку сообщений', ['/all-msg'], ['class' => 'btn btn-warning']);
}