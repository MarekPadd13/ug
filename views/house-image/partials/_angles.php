
<?php foreach ($model->angleGroup as $index => $angle):?>
<div class="row">
    <div class="col-md-12">
        <h4><?= $angle->angle->name. ". Дата последнего снимка: " . $model->getAnglesImage($angle->angle_id)->dateView ?></h4>
        <?= $this->render('_angle', [
            'model' => $model,
            'angle_id' => $angle->angle_id
        ]) ?>
    </div>
</div>
<?php endforeach; ?>