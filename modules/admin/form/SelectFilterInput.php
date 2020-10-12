<?php


namespace app\modules\admin\form;


use kartik\select2\Select2;

class SelectFilterInput
{
    public static function dataSearchModel($model, $data, $searchAttribute, $value) {
        return Select2::widget([
            'model' => $model,
            'attribute' =>  $searchAttribute,
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
}