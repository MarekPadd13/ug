<?php

use yii\helpers\Html;
use himiklab\yii2\ajaxedgrid\GridView;
use \app\modules\sending\models\Sending;

/**
 * @var $dataProvider
 */

$this->title = 'Мои сообщения';
$this->params['breadcrumbs'][] = $this->title;


$allSendingName = Sending::find()->select('name')->indexBy('id')->column();


GridView::widget([
    'dataProvider' => $dataProvider,
    'readOnly' => true,
    'columns' => [
        [
            'attribute' => 'sending_id',
            'format' => 'raw',
            'value' => function ($model) use ($allSendingName) {
                return Html::a($allSendingName[$model->sending_id], ['/msg-view', 'hash' => $model->hash]);
            }
        ],
    ],
]);