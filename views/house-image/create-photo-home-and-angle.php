<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $home \app\models\DictHouses */
/* @var $angleName string */

$this->title = 'Загрузить фото дома '.$home->name.". Ракурс: ".$angleName;
$this->params['breadcrumbs'][] = ['label' => 'Список домов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>'Ход строительства дома '.$home->name, 'url' => ['view', 'id'=> $home->id]];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stream-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('@app/modules/admin/views/home-image/_form', [
        'model' => $model,
    ]) ?>

</div>
