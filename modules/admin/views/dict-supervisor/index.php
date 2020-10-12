<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DictDictSupervisorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dict Supervisors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-supervisor-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dict Supervisor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'last_name',
            'first_name',
            'patronymic',
            'email:email',
            //'phone',
            //'post',
            //'dict_faculty_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
