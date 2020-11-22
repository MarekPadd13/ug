<?php
use yii\helpers\Html;
$array = []
?>
<?= Html::a("Все ракурсы", ['view', 'id'=>$model->id,], ['class' => 'btn btn-danger']) ?>
<?php foreach ($model->angleGroup as $index => $angle): $array[$angle->angle_id] = $angle->angle->name; ?>
    <?= Html::a($angle->angle->name, ['view', 'id'=>$model->id, 'angle_id'=> $angle->angle_id], ['class' => 'btn btn-link']) ?>
<?php endforeach; ?>

<?php if($array && key_exists($angle_id, $array)) :
   $homeImage = $model->getAnglesImage($angle_id);
    $text = "Дом №". $model->name .". Ракурс ". $array[$angle_id].". " ?>
    <h4>
        <span style="color: <?= $homeImage && $homeImage->published ? "green" : "black"?>"><?=$array[$angle_id] . ($homeImage ? ".  Дата последнего снимка: " . $homeImage->dateView : "") ?></span>
        <?= $homeImage  ? Html::a("Загрузить фото", ['add-photo-home-and-angle', 'home_id'=> $model->id, 'angle_id'=> $angle_id, ],
            ['class'=> 'btn btn-link']) : '' ?>
        <a class= 'btn btn-link' href="https://api.whatsapp.com/send?phone=79670262728&text=<?= $text ?>">Нашли изменения?</a>
    </h4>
    <?php if($homeImage && $homeImage->published) : ?>
    <p>Есть изменения: <?= $homeImage->description ?></p>
    <?php endif;?>

<?php endif; ?>