<?php

use yii\grid\GridView;
use yii\helpers\Html;
use app\components\DateTimeToChpu;

$this->title = 'Довезу до ЖК';
$this->params['breadcrumbs'][] = $this->title;


?>
    <h1><?= $this->title ?></h1>

    <p>Сервис, который позволяет находить себе попутчиков по дороге от метро до ЖК "Видный город" и обратно.
        Работает по принципу многих карпулинговых онлайн-сервисов! Предполагается, что все предложения водителей будут
        бесплатными. В качестве бонуса для водителя предлагается знакомство и приятное общение по пути до ЖК и обратно.
        Если Вам не сложно подвезти соседа, например, до офиса ЖК, то заполните следующую форму, добавив станции метро,
        которые Вы будете проезжать мимо по дороге в ЖК.
        После заполнения формы всем дольщикам будет доступно Ваше предложение. Каждый желающий
        поехать с Вами займет вакантное место и сможет написать Вам в whatsapp соответствующее сообщение по телефону, указанному
        в Вашем профиле или позвонить.</p>


<?php if ($result): ?>
    <div class="row">
        <div class="col-md-6 col-md-offset-4">
        <?=Html::decode($result)?>
        </div>
    </div>

<?php endif; ?>

<?= Html::a('Предложить поездку', 'add-trip', ['class' => 'btn btn-primary']) ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],


        [
            'attribute' => 'type_id',
            'format' => 'raw',
            'value' => function ($model) use ($typeTrip) {
                $profile = \app\models\Profiles::find()->andWhere(['user_id' => $model->user_id])->one();
                return $typeTrip[$model->type_id]
                    . '<br/>'
                    . '<br/>'
                    . '<strong>Водитель:</strong> <br/>' . $profile->shortFio()
                    . '<br/>'
                    . ($model->note ? '<strong>Комментарий водителя: </strong>'. $model->note : '');
            },
            'filter' => $typeTrip,
        ],

        [
            'attribute' => 'date',
            'format' => 'date',
            'value' => 'date',
            'filter' => $allDate,

        ],

        [
            'attribute' => 'Cтанции метро для посадки/высадки пассажиров',
            'format' => 'raw',
            'value' => function ($model) use ($metro) {
                $result = '';

                $metroTrip = $model->carpoolingMetros;

                if ($metroTrip) {
                    if ($model->type_id == 1 ||  $model->type_id == 3) {
                        $result .= '<strong>Посадка пассажиров возле станций метро:</strong><br/>';
                    } else {
                        $result .= '<strong>Высадка пассажиров возле станций метро:</strong><br/>';
                    }
                }
                foreach ($metroTrip as $eachMetro) {
                    $result .= $metro[$eachMetro->metro_id];
                    $result .= ' (примерное время ' . DateTimeToChpu::getTimeChpu($eachMetro->time) . ').';
                    $result .= '<br/>';
                }
                return $result;
            }
        ],

        ['attribute' => 'Осталось пассажирских мест',
            'format' => 'raw',
            'value' => function ($model) {
                return '<h3 align="center">'
                    . \app\models\CarpoolingTrip::correctPlaces($model->vacantPlaces())
                    . '</h3>'
                    . '<p align="center">'
                    . ($model->vacantPlaces() !== 0 ? Html::a('Забронировать место', [
                        'add-passenger', 'tripId' => $model->id]) : '')
                    . '</p>';
            },
        ],


    ],
]); ?>