<?php
use yii\helpers\Html;


$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Все текущие проблемы', 'url' => ['/site/all-problems']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <?=$model->content;?>
    </div>

</div>


