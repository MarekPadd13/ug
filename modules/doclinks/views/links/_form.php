<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\DictCategoryDoc;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Links */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $categoryId = ArrayHelper::map(DictCategoryDoc::find()->andWhere(['type_id' => 1])->all(), 'id', 'name') ?>

<div class="links-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'href')->textInput() ?>

    <?= $form->field($model, 'category_id')->widget(Select2::className(), [
        'data' => $categoryId,
        'options' => ['placeholder' => 'Выберите категорию'],
        'pluginOptions' => [
            'allowClear' => true,
        ],

    ]) ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
