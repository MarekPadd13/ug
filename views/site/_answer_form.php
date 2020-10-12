<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(['id' => 'add-ball-answer']); ?>
    <div id="answer-voter">
        <?= Html::a(
            'Голосовать за',
            '#myModal3',
            [
                'data-pjax' => '0',
                'data-toggle' => 'modal',
                'data-modal' => '#myModal3',
                'class' => 'btn btn-success',
                'data-remote' => Url::toRoute(['/site/add-voice-plus', 'id' => $no_voiting_answer->id]),
            ]
        ); ?>

        <?= Html::a(
            'Голосовать против',
            '#myModal4',
            [
                'data-pjax' => '0',
                'data-toggle' => 'modal',
                'data-modal' => '#myModal4',
                'class' => 'btn btn-danger',
                'data-remote' => Url::toRoute(['/site/add-voice-minus', 'id' => $no_voiting_answer->id])
            ]
        ); ?>
    </div>

<?php
$this->registerJs(<<<JS
$("#answer-voter").on("click", "a[data-toggle='modal']", function() {
    var button = $(this);
    $("div" + button.data("modal") + " div.modal-body").load(button.data("remote"));
});
JS
);
?>

<?php ActiveForm::end();