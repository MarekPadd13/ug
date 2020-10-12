<?php

use himiklab\yii2\ajaxedgrid\GridView;

/**
 * @var $dataProvider
 */

$checkStatus = \app\modules\sending\models\DictSendingTemplate::CHECK_STATUS_TYPE;

GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'name',
        [
            'attribute' => 'check_status',
            'value' => function ($model) use ($checkStatus) {
                return $checkStatus[$model->check_status];
            }
        ],
    ],

]);