<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $homeName string */
/* @var $angleName string */

$this->title = 'Загрузить фото дома '.$homeName. ". Ракурс: ".$angleName ?>
<div class="stream-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('@app/modules/admin/views/home-image/_form', [
        'model' => $model,
    ]) ?>

</div>
