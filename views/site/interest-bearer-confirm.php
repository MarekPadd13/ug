<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Profiles;
use yii\helpers\ArrayHelper;
use app\models\DictHouses;
use yii\helpers\Url;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Newssearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Подтвердить дольщика';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
//            'last_name',
            [
                'attribute' => 'profile.last_name',
                'format' => 'raw',
                'value' => function ($model) use ($user) {

                    if ($model->profile) {
                        return $model->profile->last_name . " <br/>Логин: " . $user[$model->user_id];
                    }

                }
            ],
            'profile.first_name',
            'profile.patronymic',
            'apart_number',
            [
                'attribute' => 'profile.phone',
                'format' => 'raw',
                'value' => function ($model) use ($currentProfile, $house) {

                    if ($model->confirm == false && $model->profile) {
                        return $model->profile->phone . " <br/>" .
                            '<a target="_blank" href="https://api.whatsapp.com/send?' .
                            'phone=' . str_replace(array('+', ' ', '(', ')', '-'), '', $model->profile->phone) .
                            '&text=Здравствуйте, ' . $model->profile->first_name . ' ' . $model->profile->patronymic .
                            '! Меня зовут ' . $currentProfile->first_name .
                            ', мы проверяем наш чат и собираем информацию по дольщикам нашего дома. ' .
                            ' Вы ранее регистрировались на сайте jk-vidniy-gorod.ru, но Ваш статус дольщика не подтвержден. ' .
                            'Вы подтверждаете, что купили квартиру в ЖК ' .
                            '&quot;Видный город &quot;, дом №' .
                            $house[$model->house_id] .
                            ' квартира №' . $model->apart_number . '?' . '">Подтвердить по WhatsApp</a>';

                    } else {
                        if ($model->profile) {
                            return '<p color="gray">' . $model->profile->phone . '</p>';
                        }
                    }

                }
            ],

            // 'page:ntext',
            // 'date_of_publication',
            //'status',
            [
                'attribute' => 'confirm',
                'format' => 'raw',
                'value' => function ($model) use ($currentProfile) {
                    if ($model->confirm == false && $model->profile) {
                        return Html::a('подтвердить', ['site/ib-confirm', 'userId' => $model->user_id,
                            'houseId' => $model->house_id], ['class' => 'confirm']);

                    } else {
                        If ($model->profile) {
                            return '<p color="gray">подтвеждено</p><p>' .
                                Html::a('отменить', ['site/ib-confirm', 'userId' => $model->user_id,
                                    'houseId' => $model->house_id, 'cancel' => true]) .
                                '</p><p><a target="_blank" href="https://api.whatsapp.com/send?' .
                                'phone=' . str_replace(array('+', ' ', '(', ')', '-'), '', $model->profile->phone) .
                                '&text=Здравствуйте, ' . $model->profile->first_name . ' ' . $model->profile->patronymic .
                                '! Ваш профиль дольщика на сайте jk-vidniy-gorod.ru подтвержден' .
                                '. Теперь Вы можете принимать участие в голосованиях и опросах как своего дома, так и в ЖК в целом' .
                                '. Спасибо Вам за активность!' .
                                '">Сообщить о подтверждении по WhatsApp</a></p>';
                        }
                    }
                }
            ],


        ],
    ]);

    ?>

</div>
