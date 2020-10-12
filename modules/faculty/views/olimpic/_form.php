<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\DictChairmans;
use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;
use app\models\DictClass;
use app\models\DictFaculty;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\bootstrap\Modal;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Olimpic */
/* @var $form yii\widgets\ActiveForm */


$chairmans = DictChairmans::find()
    ->select(['concat_ws(" ", last_name, first_name, patronymic)'])
    ->indexBy('id')
    ->column();


$typeClasses = DictClass::typeOfClass();
$classes = ArrayHelper::map(DictClass::find()->all(), 'id', function ($model) use ($typeClasses) {
    return $model->name . '-й ' . $typeClasses[$model->type];
});

$faculty = DictFaculty::find()->select('full_name')->indexBy('id')->column();

?>

<?php $form = ActiveForm::begin(['options' => ['autocomplete' => 'off']]); ?>

<?= $form->field($model, 'prefilling')->dropDownList($model::prefilling()) ?>

<?= $form->field($model, 'chairman_id')->widget(Select2::className(), [
    'data' => $chairmans,
    'options' => ['placeholder' => 'Выберите председателя оргкоммитета'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]) ?>
<?php if ($model->isNewRecord) : ?>
    <div id="answer-details">

        <?php
        echo Html::a('Добавить нового председателя',
            '#addChairman',
            [
                'data-pjax' => '0',
                'data-toggle' => 'modal',
                'data-modal' => '#addChairman',
                'data-remote' => Url::toRoute(['/faculty/dict-chairmans/create-from-olimpic']),
            ]); ?>
    </div>

<?php endif; ?>


<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'genitive_name')->textInput(['maxlength' => true]) ?>


<?php if (Yii::$app->user->can('adminFaculty')): ?>
    <?= $form->field($model, 'faculty_id')->widget(Select2::className(), [
        'data' => $faculty,
        'options' => ['placeholder' => 'Учредитель мероприятия'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>
<?php endif; ?>

<?= $form->field($model, 'edu_level_olymp')->dropDownList($model::levelOlimp()) ?>

<?= $form->field($model, 'only_mpgu_students')->checkbox(); ?>



<?= $form->field($model, 'competitiveGroupsList')->widget(Select2::className(), [
    'options' => ['placeholder' => 'Выберите конкурсные группы', 'multiple' => true],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]) ?>

<?= $form->field($model, 'classesList')->widget(Select2::className(), [
    'options' => ['placeholder' => 'Выберите классы и курсы', 'multiple' => true],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]) ?>

<?= $form->field($model, 'number_of_tours')->dropDownList($model::numberOfTours()) ?>

<?= $form->field($model, 'form_of_passage')->dropDownList($model::formOfPassage()) ?>


<?php echo $form->field($model, 'date_time_start_reg')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Введите дату и время ...'],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy.mm.dd hh:ii'
    ]
]);
?>

<?php echo $form->field($model, 'date_time_finish_reg')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Введите дату и время ...'],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy.mm.dd hh:ii'
    ]
]);
?>

<?= $form->field($model, 'time_of_distants_tour_type')->dropDownList($model::typeOfTimeDistanceTour()); ?>

<?= $form->field($model, 'time_of_distants_tour')->textInput(['type' => 'number']) ?>


<?php echo $form->field($model, 'date_time_start_tour')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Введите дату и время ...'],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy.mm.dd hh:ii'
    ]
]);
?>

<?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'time_of_tour')->textInput() ?>

<?= $form->field($model, 'requiment_to_work_of_distance_tour')->widget(CKEditor::className(), [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
]); ?>

<?= $form->field($model, 'requiment_to_work')->widget(CKEditor::className(), [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash'])
]); ?>


<?= $form->field($model, 'criteria_for_evaluating_dt')->widget(CKEditor::className(), [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash'])
]); ?>

<?= $form->field($model, 'criteria_for_evaluating')->widget(CKEditor::className(), [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash'])
]); ?>


<?= $form->field($model, 'showing_works_and_appeal')->dropDownList($model::showingWork()) ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>



<?php Modal::begin(['id' => 'addChairman', 'header' => '<h4 class="modal-title">Добавить нового председателя</h4>', 'size' => Modal::SIZE_LARGE]) ?>
<?php
echo "<div id='modalContent1'>";
echo "</div>";
Modal::end() ?>

</div>
<?php
$this->registerJs(<<<JS
$("#answer-details").on("click", "a[data-toggle='modal']", function() {
    var button = $(this);
    $("div" + button.data("modal") + " div.modal-body").load(button.data("remote"));
   
});
JS
);
?>


<?php
$this->registerJs(<<<JS

// var str = $("#olimpic-name").val();
//
// $("#olimpic-name").blur(function(){
//   $("#olimpic-name").val(str[0].toUpperCase() + str.slice(1));
// })

var formOfPassage = $("div.field-olimpic-form_of_passage");
var mpguStatus = $("div.field-olimpic-only_mpgu_students");
var typeOfTime = $("div.field-olimpic-time_of_distants_tour");
var hideTypeOfTime = $("div.field-olimpic-time_of_distants_tour_type");
var hideTimeOfOchTour = $("div.field-olimpic-date_time_start_tour");
var hideDateTimeStartOchTour = $("div.field-olimpic-date_time_start_tour");
var hideAddress = $("div.field-olimpic-address");
var hideTimeOchTur = $("div.field-olimpic-time_of_tour");
var hideZaochRequired = $("div.field-olimpic-requiment_to_work_of_distance_tour");
var hideOchRequired = $("div.field-olimpic-requiment_to_work");
var hideZaochCriteria = $("div.field-olimpic-criteria_for_evaluating_dt");
var hideOchCriteria = $("div.field-olimpic-criteria_for_evaluating");

$("#olimpic-form_of_passage").on("change init", function() {
    if(this.value == 1){
        hideTimeOfOchTour.show();
        hideDateTimeStartOchTour.show();
        hideAddress.show();
        hideTimeOchTur.show();
        hideOchRequired.show();
        hideOchCriteria.show();
    }else{
        hideTypeOfTime.hide();
        hideTimeOfOchTour.hide();
        hideDateTimeStartOchTour.hide();
        hideAddress.hide();
        typeOfTime.hide();
        hideTimeOchTur.hide();
        hideOchRequired.hide();
        hideOchCriteria.hide();
    };
    
    if(this.value == 2){
        hideZaochRequired.show();
        hideZaochCriteria.show();
        hideTypeOfTime.show();
    }else{
        hideZaochRequired.hide();
        hideZaochCriteria.hide();
    }
}).trigger("init");

$("#olimpic-number_of_tours").on("change init", function() {
    if(this.value == 2){
        hideTimeOfOchTour.show();
        hideDateTimeStartOchTour.show();
        hideAddress.show();
        hideTimeOchTur.show();
        hideOchRequired.show();
        hideOchCriteria.show();
        hideZaochRequired.show();
        hideZaochCriteria.show();
        hideTypeOfTime.show();
    }else{
        hideTypeOfTime.hide();
        hideTimeOfOchTour.hide();
        hideDateTimeStartOchTour.hide();
        hideAddress.hide();
        typeOfTime.hide();
        hideTimeOchTur.hide();
        hideOchRequired.hide();
        hideOchCriteria.hide();
        hideZaochRequired.hide();
        hideZaochCriteria.hide();
    }
});

$("#olimpic-number_of_tours").on("change init", function() {
    if (this.value == 1) { //@todo сделать константой
        formOfPassage.show();
        $("#olimpic-form_of_passage option[value='3']").remove();
    } else {
        formOfPassage.hide();
    }
}).trigger("init");



$("#olimpic-edu_level_olymp").on("change init", function() {
    if (this.value == 2) { //@todo сделать константой
        mpguStatus.show();
    } else {
        mpguStatus.hide();
    }
}).trigger("init");

$("#olimpic-time_of_distants_tour_type").on("change init", function() {
    if (this.value == 1) { //@todo сделать константой
        typeOfTime.show();
    } else {
        typeOfTime.hide();
    }
}).trigger("init");


var levelSelect = $("#olimpic-edu_level_olymp");
var loadedCg = []; // Текущий список КГ
var loadedClass = [];
var clSelect = $("#olimpic-classeslist");
var cGSelect = $("#olimpic-competitivegroupslist");

levelSelect.on("change init", function(){
    $.ajax({
    url: "/faculty/olimpic/get-cg",
    method: "GET",
    dataType: "json",
    async: false,
    data: {levelId: levelSelect.val()},
    success: function (groups){
        var cg = groups.result;
        loadedCg = cg;
        var oldCg = cGSelect.val();
        cGSelect.val("").trigger("change");
        cGSelect.empty();
        cGSelect.append("<option value=''></option>");
        
                    for (var num in cg) {
                cGSelect.
                    append($("<option></option>").attr("value", cg[num].id).text(cg[num].text));
            }

            if (oldCg) {
                cGSelect.val(oldCg).trigger("change");
            }
        },
        error: function() {
            alert('Произошла непредвиденная ошибка. Пожалуйста, обратитесь к администратору.');
        }
        
    });
$.ajax({
url: "/faculty/dict-class/get-class-on-type",
method: "GET",
dataType: "json",
async: false,
data: {onlyHs: levelSelect.val()},

    success: function (classes){
        var cl = classes.class;
        loadedClass = cl;
        var oldClass = clSelect.val();
        clSelect.val("").trigger("change");
        clSelect.empty();
        clSelect.append("<option value=''></option>");
        
                    for (var num in cl) {
                clSelect.
                    append($("<option></option>").attr("value", cl[num].id).text(cl[num].name));
            }

            if (oldClass) {
                clSelect.val(oldClass).trigger("change");
            }
        },
        error: function() {
            alert('Произошла непредвиденная ошибка. Пожалуйста, обратитесь к администратору.');
        }

    });
    
   
});


levelSelect.trigger("init");

JS
);
?>

