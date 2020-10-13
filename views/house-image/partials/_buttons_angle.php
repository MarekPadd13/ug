<?php
use yii\helpers\Html;
$array = []
?>
<?= Html::a("Все ракурсы", ['view', 'id'=>$model->id,], ['class' => 'btn btn-danger']) ?>
<?php foreach ($model->angleGroup as $index => $angle): $array[$angle->angle_id] = $angle->angle->name; ?>
    <?= Html::a($angle->angle->name, ['view', 'id'=>$model->id, 'angle_id'=> $angle->angle_id], ['class' => 'btn btn-info']) ?>
<?php endforeach; ?>
<h3><?= $array && key_exists($angle_id, $array)  ? $array[$angle_id]:  "" ?></h3>