<?php
/**
 * Created by PhpStorm.
 * User: ramil
 * Date: 21.10.2018
 * Time: 18:05
 */

use yii\helpers\Html;
?>
<div class="mt-100 container">
<h1 align="center">Розыгрыш проводится среди тех, кто был зарегистрирован на данное мероприятие на сайте sdo.mpgu.org</h1>
<?php
echo Html::tag('div', '', ['class' => 'lottery']); ?>
    <div class"row">
    <div class="col-md-4 col-md-offset-4">

        <?php
        echo Html::button('Определить победителя', ['class' => 'btn btn-success lottery-button']);
        echo " " . Html::button('Новый розыгрыш', ['class' => 'btn btn-warning refresh']);
        ?>
    </div>
    </div>
    </div>

<?php $json = json_encode($members); ?>

<?php $this->registerJS(<<<JS

    var member = $json;
    $('.lottery-button').click(function(){
        $.each(member, function(i, full_name){
        setTimeout(function(){
          
            $(".lottery").text(full_name)},10 * i);
            });
    });
    $(".refresh").click(function() {
      location.reload();
    })

JS
);
