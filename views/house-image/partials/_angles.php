
<?php use yii\helpers\Html;

foreach ($model->angleGroup as $index => $angle): $homeImage = $model->getAnglesImage($angle->angle_id) ?>
<div class="row">
    <div class="col-md-12">
        <h4>
            <span style="color: <?= $homeImage && $homeImage->published ? "green" : "black"?>"><?= $angle->angle->name . ($homeImage ? ".  Дата последнего снимка: " . $homeImage->dateView : "") ?></span>
            <?= $homeImage ? Html::a("Загрузить фото", ['add-photo-home-and-angle', 'home_id'=> $model->id, 'angle_id'=> $angle->angle_id, ],
                ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => "", 'class'=> 'btn btn-info']) : "" ?>
        </h4>
        <?php if($homeImage && $homeImage->published) : ?>
            <p><?= $homeImage->description ?></p>
        <?php endif;?>
        <?= $this->render('_angle', [
            'model' => $model,
            'angle_id' => $angle->angle_id
        ]) ?>
    </div>
</div>
<?php endforeach; ?>