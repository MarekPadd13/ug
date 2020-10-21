<?php


namespace app\modules\admin\form;


use kartik\date\DatePicker;
use kartik\select2\Select2;

class SelectFilterInput
{
    public static function dataSearchModel($model, $data, $searchAttribute, $value)
    {
        return Select2::widget([
            'model' => $model,
            'attribute' => $searchAttribute,
            'data' => $data,
            'value' => $value,
            'options' => [
                'class' => 'form-control',
                'placeholder' => 'Выберите значение'
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'selectOnClose' => true,
            ]
        ]);
    }

    public static function dateWidgetRangeSearch($searchModel, $from, $to, $type = DatePicker::TYPE_INPUT)
    {
        return DatePicker::widget([
            'language' => 'ru',
            'model' => $searchModel,
            'attribute' => $from,
            'attribute2' => $to,
            'type' => $type,
            'separator' => '-',
            'pluginOptions' => [
                'todayHighlight' => true,
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
            ],
        ]);
    }
}