<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\DictCategoryDoc;

/* @var $this yii\web\View */
/* @var $model app\models\Documents */
/* @var $form yii\widgets\ActiveForm */

$categories = ArrayHelper::map(DictCategoryDoc::find()->andWhere(['type_id' => DictCategoryDoc::TYPEDOC])->all(), 'id', 'name');
?>

<div class="documents-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'category_id')->widget(Select2::className(), [
        'data' => $categories,
        'options'=> ['placeholder'=> 'Выберите категорию'],
        'pluginOptions'=> ['clearAllow'=> true],
    ]) ?>

    <?= $form->field($model, 'documentFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
