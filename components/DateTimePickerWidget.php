<?php

namespace app\components;

use app\assets\DateTimePickerAssets;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class DateTimePickerWidget extends InputWidget
{
    public $clientOptions = [];

    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textInput($this->name, $this->value, $this->options);
        }

        $this->registerClientScript();
    }

    protected function registerClientScript()
    {
        $view = $this->getView();

        DateTimePickerAssets::register($view);
        $id = $this->options['id'];
        $options = Json::encode($this->clientOptions);
        $view->registerJs("jQuery('#$id').datetimepicker($options);");
    }
}
