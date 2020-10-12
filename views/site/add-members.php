<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use yii\widgets\MaskedInput;
use app\models\RefDoljnost;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use common\widgets\Alert;

$this->title = 'Сформировать команду (шаг 2)';
//$this->params['breadcrumbs'][] = ['label' => $porblems->name, 'url' => ['/site/full-text', 'id' => $problem->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3>Шаг 2. Какую команду Вам нужно сформировать для решения данной проблемы (укажите должности и количество людей):</h3>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
<?php $form = ActiveForm::begin(['id' => 'add-members-form']); ?>

<?= $form->field($model, 'doljnost_id')->widget(Select2::className(), [
    'data' => ArrayHelper::map(RefDoljnost::find()->andWhere(['or', ['moderation'=> true], ['user_id'=> Yii::$app->user->id]])->all(), 'id', 'name'),
    'language' => 'ru',
    'options' => ['placeholder' => 'Выберите  должность', "id"=>'select'],
    'pluginOptions' => [
        'allowClear' => true
    ],
    "pluginEvents" => [
    "change" => 'function() {$.post("dol?id='.'"+$(this).val(), function(data) {
                  $("[id=delres]").text(data);
              })}'

    ],
]); ?>
<p id ="delres"><p>
<?=Html::a('Предложить должность', ['add-positions', 'id'=>$model->ref_answer_id], ['data-pjax' => 'w0', 'data-toggle' => 'modal1', 'target' => '#myModal1'])?>


<?= $form->field($model, 'count')->textInput()?>




        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        // 'id',
        'doljnost.name',
        'count',
        // 'page:ntext',
        // 'date_of_publication',
        //'status',

        ['class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => [
                    'delete'=> function ($url, $model, $key){
                        return Html::a(Html::tag('span','', ['class'=>'glyphicon glyphicon-trash']), ['delete-member', 'id'=>$model->id], ['data' => ['confirm'=> 'Вы действительно хотите удалить?', 'method'=> 'POST']]);
                    },
                ],
            ],
    ],
]); ?>
<?=Html::tag('div', Html::a('Закончить', '/site/all-problems', ['class'=> 'btn btn-danger']), ['class'=> 'col-md-2 col-md-offset-5'])?>

    </div>
</div>


<?php ActiveForm::end(); ?>

<?php Modal::begin(['id'=>'mymodal1', 'header' => '<h4 class="modal-title">Cоздание должности</h4>',])?>
<?php
echo "<div id='modalContent1'></div>";
Modal::end()?>

