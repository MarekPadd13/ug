<?php
use yii\helpers\Html;


$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Все текущие проблемы', 'url' => ['/site/all-problems']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <h1><?=$model->name;?></h1>
        <?=$model->full_text;?>
    </div>

</div>


