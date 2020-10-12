<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Templates;
use app\models\OlimpiadsTypeTemplates;

/* @var $this yii\web\View */
/* @var $model app\models\Olimpic */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады/Конкурсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'chairman_id',
            'number_of_tours',
            'form_of_passage',
            'edu_level_olymp',
            'date_time_start_reg',
            'date_time_finish_reg',
            'time_of_distants_tour',
            'date_time_start_tour',
            'address:ntext',
            'time_of_tour',
            'requiment_to_work_of_distance_tour:ntext',
            'requiment_to_work:ntext',
            'criteria_for_evaluating_dt:ntext',
            'criteria_for_evaluating:ntext',
            'showing_works_and_appeal',
        ],
    ]) ?>

    <?php

    $allTemplates = OlimpiadsTypeTemplates::find()
        ->andWhere(['number_of_tours' => $model->number_of_tours])
        ->andWhere(['form_of_passage' => $model->form_of_passage])
        ->andWhere(['edu_level_olimp' => $model->edu_level_olymp])
        ->all();

    $templatesName = Templates::find()->select('name')->indexBy('id')->column();

    if ($allTemplates) {
        foreach ($allTemplates as $template) {
            echo Html::a($templatesName[$template->template_id],
                    ['/print/olimp-docs',
                        'tempId' => $template->template_id,
                        'olimpId' => $model->id]) . '<br/>';
        }
    }

    ?>


</div>
