<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Olimpic;

$numberOfTours = Olimpic::numberOfTours();
$formOfPassage = Olimpic::formOfPassage();
$eduLevel = Olimpic::levelOlimp();
$templates = \app\models\Templates::find()->select('name')->indexBy('id')->column();

/* @var $this yii\web\View */
/* @var $searchModel app\models\OlimpiadsTypeTemplatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сопоставление шаблонов различным типам олимпиад';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'number_of_tours',
                'value' => function ($model) use ($numberOfTours) {
                    return $numberOfTours[$model->number_of_tours];
                },
                'filter' => $numberOfTours,
            ],
            [
                'attribute' => 'form_of_passage',
                'value' => function ($model) use ($formOfPassage) {
                    return $formOfPassage[$model->form_of_passage];
                },
                'filter' => $formOfPassage,
            ],
            [
                'attribute' => 'edu_level_olimp',
                'value' => function ($model) use ($eduLevel) {
                    return $eduLevel[$model->edu_level_olimp];
                },
                'filter' => $eduLevel,
            ],
            ['attribute' => 'template_id',
                'value' => function ($model) use ($templates) {
                    return $templates[$model->template_id];
                },
                'filter' => $templates,
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>
</div>
