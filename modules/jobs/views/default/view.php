<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\RefDoljnost;
use common\widgets\Alert;
use app\models\SolutionsProfiles;
?>
<?php
$dojnost = ArrayHelper::map(RefDoljnost::find()->all(), 'id', 'name');
$description = ArrayHelper::map(RefDoljnost::find()->all(), 'id', 'description');
$solution_profiles = SolutionsProfiles::find()->andWhere(['user_id'=> Yii::$app->user->id])->andWhere(['answer_id'=> $model->id])->one();
?>

<div class="row">
    <div class="col-md-12">
        <h2><?=$model->name?></h2>
        <div><?=$model->description?></div>
       <div><?=$model->content?></div>
    </div>
    <div class="col-md-12">
        <?php if(isset($solution_profiles)){?>
              <p>Вы уже приимаете участие. Ваша должность: <?=$dojnost[$solution_profiles->member_id]?>
        <?php }else{?>

        <?php if(isset($model->members)){?>
            <h3>Принять учаcтие:</h3>
        <?php }?>
        <?php foreach ($model->members as $position){?>
            <p>
                <?php echo Html::a($dojnost[$position->doljnost_id], ['add-member', 'id'=>$model->id, 'position'=> $position->id], ['data' => ['confirm'=> 'Вы действительно хотите принять участие в этом качестве?', 'method'=> 'POST']]);
                echo ' ('. $position->count.') ';
                echo $description[$position->doljnost_id].";<br>";
                ?>
            </p>
            <?php }?>
        <?php }?>
    </div>
</div>

