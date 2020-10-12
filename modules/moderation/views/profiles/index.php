<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProfilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Profiles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profiles-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Profiles', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'last_name',
            'first_name',
            'patronymic',
            //'phone',
            //'vk_id',
            //'bank_id',
            //'house_id',
            //'number_of_apart',
            //'number_duu',
            //'date_ddu',
            //'number_credit',
            //'date_credit',
            //'activizm_id',
            //'what_will_you_do',
            //'what_do_with_bank',
            //'recognition_of_insurance',
            //'ddu_type',
            //'acreditive',
            //'mother_capital',
            //'miting',
            //'confirm',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
