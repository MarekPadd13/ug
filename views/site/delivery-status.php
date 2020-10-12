<?php
/**
 * Created by PhpStorm.
 * User: ramil
 * Date: 05/03/2019
 * Time: 18:30
 */

/**
 * @var $dataProvider
 */

use himiklab\yii2\ajaxedgrid\GridView;
use yii\helpers\Html;
use app\modules\sending\models\Sending;

if(Sending::PersentUserInCategory($sendingId))
{
    echo Html::a('Доотправить вновь прибывшим', ['add-to-sending-new-user-house', 'sendingId'=>$sendingId],
        ['class'=> 'btn btn-warning']);
}

$profiles = \app\models\Profiles::getFullNameAllProfiles();

$status = \app\modules\sending\models\SendingDeliveryStatus::ALL_EMAIL_STATUS;

$phone = \app\models\Profiles::getPhone();


GridView::widget([
    'dataProvider' => $dataProvider,
    'readOnly' => true,
    'columns' => [
        [
            'attribute' => 'user_id',
            'value' => function ($model) use ($profiles) {
                return $profiles[$model->user_id] ?? null;
            }
        ],
        [
            'attribute' => 'status_id',
            'format' => 'raw',
            'value' => function ($model) use ($status, $phone) {
                $result = $status[$model->status_id];

                if ($model->status_id !== \app\modules\sending\models\SendingDeliveryStatus::STATUS_HAS_POLL) {
                    $result .= '<br/>';
                    $result .= isset($phone[$model->user_id]) ? '<a href="https://api.whatsapp.com/send?'
                        . 'phone=' . str_replace(array('+', ' ', '(', ')', '-'), '', $phone[$model->user_id])
                        . '&text='
                        . \app\modules\sending\models\Sending::getLetter(
                            $model->sending_id,
                            $model->user_id,
                            \app\modules\sending\models\Sending::TYPE_TEXT,
                            $model->hash)
                        . '">Отправить сообщение в WhatsApp</a>' : 'Не заполнен профиль';
                }
                return $result;
            }
        ]

    ],
]);