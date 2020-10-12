<?php
use yii\helpers\Html;
?>
<div class="container-fluid">
    <h3>Голосования и активность дольщиков</h3>
    <div class="row">
        <div class="col-md-12">
           <?=Html::a('Электорат составляет - '.$profiles.' дольщика(ов)' , '/moderation/profiles')?>
        </div>

            <div class="col-md-12">
                <?=Html::a('Предложены на модерацию - '.$problems.' проблем(а)' , '/moderation/problems')?>

            </div>

    </div>

</div>
