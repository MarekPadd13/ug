<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = "Все текущие проблемы";
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Yii::setAlias('@wa', 'https://wa.me/send');?>

    <div class="row pt-30">
        <div class="col-md-12">
            <h2>Все текущие проблемы</h2>
        </div>
    </div>
<div class="row">
    <div class="col-md-12">
<?=Html::a('Добавить', ['add-problems'], ['class' => 'btn btn-primary'])?>
    </div>
</div>

<div class="row">

        <?php foreach ($problems as $all_problems){?>
    <div class="col-md-12">
        <?php $this_user = Yii::$app->user->id?>
        <?php if($all_problems->user_id == $this_user && $all_problems->moderation == false)
        {
            echo Html::tag('h3', $all_problems->name.' (на модерации)', ['class'=>'red']);
        }else{
            echo Html::tag('h3', $all_problems->name);
        }?>
       <?=Html::tag('p', $all_problems->description)
        .Html::a('Подробнее', ['full-text', 'id' => $all_problems->id])
        .Html::tag('span', ' | ')
        .Html::a('Предложить решение', ['add-solution', 'id' => $all_problems->id], ['style'=> 'color:#cc8100']);?>

        <?php if($all_problems->user_id == $this_user && $all_problems->moderation == false)
        {
        echo Html::tag('span', ' | ').Html::a('Редактировать', ['update-problem', 'id' => $all_problems->id]);
        echo Html::tag('span', ' | ').Html::a('Удалить',['delete-problem', 'id' => $all_problems->id], [
//            'data-toggle'=>'tooltip',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить?',
                'method' => 'post',
            ],
        ]);
        }
        ?>

    </div>
        <?php }?>
</div>

