<?php

use yii\helpers\Html;

?>

<?php
$this->title = 'Олимпиады и конкурсы МПГУ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

<h1><?php echo $this->title ?></h1>

    <div class="row">
        <?= Html::decode($result); ?>
    </div>
</div>
