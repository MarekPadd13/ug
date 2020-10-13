<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \app\modules\admin\form\HomeImageForm */
/* @var $home \app\models\DictHouses */

$this->title = 'Загрузить фото дома '.$home->name;
$this->params['breadcrumbs'][] = ['label' => 'Фотографии домов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>"Фотографии домов", 'url' => ['view', 'home_id'=> $home->id]];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stream-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('@app/modules/admin/views/home-image/_form', [
        'model' => $model,
    ]) ?>

</div>
