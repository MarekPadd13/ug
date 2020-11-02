<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StreamSearch */
/* @var $data yii\data\ActiveDataProvider */

$this->title = 'Ход строительства';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stream-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        Сервис для свободной загрузки (без предварительной регистрации) фотографий домов любых ракурсов для того, чтобы следить за темпами строительства
        и степенью готовности всех домов ЖК «Видный город».
    </p>
    <p>
        Для загрузки фото необходимо:
        <ul>
        <li>нажать на одноименную кнопку;</li>
        <li>в форме выбрать нужны ракурс (или внести новый выбрав пункт «ракурс не найден» и внеся название нового
            ракурса в соответствующее поле);</li>
        <li>указать номер дома;</li>
        <li>ссылку на источник в свободной форме, чтобы не нарушать авторское право;</li>
        <li>перетащить файл фото в поле для загрузки или нажать на кнопку выбрать и указать загружаемое фото;</li>
        <li>указать дату съемки;</li>
        <li>нажать на кнопку сохранить.</li>
    </ul>
</p>
    <p>
        После этого ваше фото пройдет модерацию и будет опубликовано. Администраторы сайта будут проверять информацию и корректировать самостоятельно.
        С вопросами и предложениями можно обращаться <a href="https://api.whatsapp.com/send?phone=79670262728">сюда</a>.
    </p>

        <div class="row mb-30">
           <div class="col-md-6 col-md-offset-3">
               <?= Html::a('Загрузить фото', ['add-photo'], ['class' => 'btn btn-success btn-lg btn-block']) ?>
           </div>
        </div>

    <?=\yii\widgets\ListView::widget([
        'dataProvider' => $data,
        'layout' => "{items}\n{pager}",
        'beforeItem' => function($model , $key , $index , $widget) {
            return  $index%3 == 0 ? '<div class="row" style="margin-bottom: 15px">':"";
        },
        'afterItem' => function($model , $key , $index , $widget) use($data) {
            return  $index%3 == 2  || ($data->getTotalCount() - 1) == $index ? '</div>': "";
        },
        'itemView' => '_item',
    ]) ?>


</div>
