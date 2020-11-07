<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\MaskedInput;
use himiklab\yii2\ajaxedgrid\GridView;
use yii\data\ActiveDataProvider;


$this->title = 'Заполнение профиля';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?=$this->title?></h1>

<?php $form = ActiveForm::begin(['id' => 'profile-form']); ?>



<?= $form->field($model, 'last_name')->textInput([\app\models\UserHouseApart::NoConfirm() ? '': 'readOnly'=> 'readOnly']) ?>
<?= $form->field($model, 'first_name')->textInput([\app\models\UserHouseApart::NoConfirm() ? '': 'readOnly'=> 'readOnly']) ?>
<?= $form->field($model, 'patronymic')->textInput([\app\models\UserHouseApart::NoConfirm() ? '': 'readOnly'=> 'readOnly']) ?>

<?php //= $form->field($model, 'photo')->fileInput() ?>


<?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
    'mask' => '+7(999)999-99-99'])->textInput([\app\models\UserHouseApart::NoConfirm() ? '': 'readOnly'=> 'readOnly'])?>


<?= $form->field($model, 'in_whatapp_chat')->checkbox([\app\models\UserHouseApart::NoConfirm() ? '': 'disabled'=> true]); ?>

<?php
//if(Yii::$app->user->can('adminAccess'))
//{
//    $readOnly = true;
//}else{
//    $readOnly = false;
//
//}

if (!$model->isNewRecord) {
    GridView::widget(
        [
            'dataProvider' => new ActiveDataProvider (['query' => $model->getHouseApart()]),
            'columns' => [
                [
                    'attribute' => 'house_id',
                    'value' => function ($model) use ($houses) {
                        return $houses[$model->house_id];
                    },
                ],
                [
                    'attribute' => 'type',
                    'value' => 'typeName'
                ],
                'entrance',
                'floor',
                'apart_number',
                'sq'
            ],
            'actionColumnTemplate' => '{delete}',
            'addButtons' => ['Добавить квартиру'],
            'createRoute' => ['site/add-apart'],
            'deleteRoute' => ['delete-apart'],
        ]


    );
}
?>


<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
</div>
