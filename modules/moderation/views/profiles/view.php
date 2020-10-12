<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Profiles */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profiles-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'last_name',
            'first_name',
            'patronymic',
            'phone',
            'vk_id',
            'bank_id',
            'house_id',
            'number_of_apart',
            'number_duu',
            'date_ddu',
            'number_credit',
            'date_credit',
            'activizm_id',
            'what_will_you_do',
            'what_do_with_bank',
            'recognition_of_insurance',
            'ddu_type',
            'acreditive',
            'mother_capital',
            'miting',
            'confirm',
        ],
    ]) ?>

</div>
