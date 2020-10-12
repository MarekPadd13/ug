<?php

use himiklab\yii2\ajaxedgrid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\sending\models\Sending;

/**
 * @var $dataProvider
 */

$typeSending = \app\modules\sending\models\Sending::TYPE_SENDING;
$allTemplateName = \app\modules\sending\models\DictSendingTemplate::getAllTemplateName();
$allCategoryName = \app\modules\sending\models\DictSendingUserCategory::getAllCategoriesName();
$checkStatus = \app\modules\sending\models\DictSendingTemplate::CHECK_STATUS_TYPE;

$this->title = 'Рассылки';
$this->params['breadcrums'][] = $this->title;

GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'name',
        [
            'attribute' => 'template_id',
            'format' => 'raw',
            'value' => function ($model) use ($allTemplateName, $checkStatus) {
                return $allTemplateName[$model->template_id] . ' (' . $checkStatus[$model->template->check_status].')';
            }
        ],
        [
            'attribute' => 'sending_category_id',
            'value' => function ($model) use ($allCategoryName) {
                return $allCategoryName[$model->sending_category_id];
            }
        ],
        [
            'attribute' => 'status_id',
            'format' => 'raw',
            'value' => function ($model) use ($typeSending) {

    if($model->status_id == Sending::FINISH_SENDING){
        $result = Html::a($typeSending[$model->status_id], ['/site/delivery-status', 'sendingId'=>$model->id]);

    }else{
        $result = $typeSending[$model->status_id];
    }
                if (Yii::$app->user->can('News_redactor') && $model->status_id == Sending::WEITING_MODERATION) {
                    $result .= '<br/>';
                    $result .= Html::a('Запустить', '#', [
                        'data-action' => 'post-request',
                        'data-remote' => Url::toRoute(['start-sending', 'sendId' => $model->id]),
                        'class' => 'btn btn-success',
                    ]);

                }
                return $result;
            }
        ],
        [
            'attribute' => 'deadline',
            'format' => 'raw',
            'value' => function ($model) {
                return \app\components\DateTimeToChpu::getDateChpu($model->deadline)
                    . ' в ' . \app\components\DateTimeToChpu::getTimeChpu($model->deadline);
            }
        ],
    ],
]);
