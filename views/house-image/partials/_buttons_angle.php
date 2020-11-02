<?php
use yii\helpers\Html;
$array = []
?>
<?= Html::a("Все ракурсы", ['view', 'id'=>$model->id,], ['class' => 'btn btn-danger']) ?>
<?php foreach ($model->angleGroup as $index => $angle): $array[$angle->angle_id] = $angle->angle->name; ?>
    <?= Html::a($angle->angle->name, ['view', 'id'=>$model->id, 'angle_id'=> $angle->angle_id], ['class' => 'btn btn-link']) ?>
<?php endforeach; ?>
<h4><?= $array && key_exists($angle_id, $array)  ? $array[$angle_id] .". Дата последнего снимка: " .$model->getAnglesImage($angle_id)->dateView :  "" ?></h4>