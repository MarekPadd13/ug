<?php
use yii\helpers\Html;
?>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <?=HTMl::a('Провести модерацию новых городов',['/admin/dict-city?DictCitySearch%5Bname%5D=&DictCitySearch%5Bmoderation%5D=0'] );?>
        <?=HTMl::tag('sup',\app\models\DictCity::getCountITemWithoutModeration());?>
        </div>
    </div>
</div>