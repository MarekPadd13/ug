
<?php foreach ($model->angleGroup as $index => $angle):?>
<div class="row">
    <div class="col-md-12">
        <h3><?= $angle->angle->name  ?></h3>
        `<?= $this->render('_angle', [
            'model' => $model,
            'angle_id' => $angle->angle_id
        ]) ?>`
    </div>
</div>
<?php endforeach; ?>