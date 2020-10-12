<?php
use yii\helpers\Html;
$this->title = "Все новости";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row pt-30">
            <div class="col-md-12">
                <h3>Все новости</h3>
            </div>
        </div>

<?=Html::decode($result);
