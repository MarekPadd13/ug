<?php

use yii\bootstrap\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use mihaildev\elfinder\ElFinder;
use app\modules\sending\models\DictSendingTemplate;


/**
 * @var $model
 */

echo 'Для составления шаблона письма, Вы можете использовать следующие автопостановки:' . '<br/>';
echo '{имя отчество получателя}' . '<br/>';
echo '{опрос}' . '<br/>';
echo '{ссылка на страницу}' . '<br/>';


$form = ActiveForm::begin(['id' => 'create-template']);

echo $form->field($model, 'name')->textInput(['maxlength' => true]);

echo $form->field($model, 'html')->widget(CKEditor::className(), [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
]);

echo $form->field($model, 'text')->textarea(['row' => 6]);

if (Yii::$app->user->can('News_redactor')) {

    echo $form->field($model, 'check_status')->checkbox();
    echo $form->field($model, 'base_type')->dropDownList(DictSendingTemplate::TYPE_OF_TEMPLATE);

}

echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']);

ActiveForm::end();

