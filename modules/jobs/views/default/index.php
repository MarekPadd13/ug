<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\RefDoljnost;
?>

<?php $dojnost = ArrayHelper::map(RefDoljnost::find()->all(), 'id', 'name');
$description = ArrayHelper::map(RefDoljnost::find()->all(), 'id', 'description');
?>

<?php
if(isset($model)){
        foreach ($model as $jobs) {
            echo Html::a(Html::tag('h4', $jobs->name), ['view', 'id' => $jobs->id]);

        }
}else{
    echo 'Нет утвержденных инициатив';
}
?>