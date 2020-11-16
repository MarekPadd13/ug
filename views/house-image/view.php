<?php

use yeesoft\lightbox\Lightbox;
use yii\bootstrap\Carousel;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DictHouses */
/* @var $image app\models\HomeImage */

$this->title = "Ход строительства дома  " . $model->name;
$this->params['breadcrumbs'][] = ['label' => "Список домов", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$itemsLight = [];
$angle_id = Yii::$app->request->get("angle_id");
$angle_id = (int)$angle_id;
?>
<div class="stream-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Загрузить фото ', ['add-photo-home', 'home_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('partials/_buttons_angle', [
        'model' => $model,
        'angle_id' => $angle_id
    ]) ?>

    <?php if ($angle_id) : ?>
        <?= $this->render('partials/_angle', [
            'model' => $model,
            'angle_id' => $angle_id
        ]) ?>
    <?php else: ?>
        <?= $this->render('partials/_angles', [
            'model' => $model,
        ]) ?>
    <?php endif; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <?php if ($model->getDataEndHomeBuild()->count()): ?>

                    <?= \app\widgets\ChartWidget::widget(['model' => $model, 'url' => ['/house-image/view', 'id' => $model->id]]); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>


</div>
<?php
$this->registerJs(<<<JS
        $("[data-target=\"#modal\"]").click(function(e) {
e.preventDefault();
var url = $(this).attr("href");
var modalTitle = $(this).attr("data-modalTitle");
var modal = $('#modal');
modal.find('#header-h4').text(modalTitle);
modal.find('#modalContent').load(url);
});
JS
);
?>

<?php Modal::begin([ 'id'=>'modal', 'size'=> Modal::SIZE_LARGE, 'header' => "<h4 id='header-h4'></h4>", 'clientOptions' => ['backdrop' => false]]) ?>
<div id='modalContent'></div>
<?php Modal::end() ?>
