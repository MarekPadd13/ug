<?php

use yii\helpers\Html;
use app\models\Stream;

$this->title = "Онлайн камеры";
$this->params['breadcrumbs'][] = $this->title;

$this->title = 'Онлайн- трансляция с нашего ЖК';

$jkName = Stream::ALL_JK;

?>

    <div class="row">

        <?php

        if (Stream::find()->andWhere(['jk_id' => 1])->exists()) {
            echo '<div class="col-md-2"">';
            echo Html::a($jkName[1], ['stream', 'jkId' => 1]);
            echo '</div>';
        }

        if (Stream::find()->andWhere(['jk_id' => 2])->exists()) {
            echo '<div class="col-md-2"">';
            echo Html::a($jkName[2], ['stream', 'jkId' => 2]);
            echo '</div>';
        }

        if (Stream::find()->andWhere(['jk_id' => 3])->exists()) {
            echo '<div class="col-md-2"">';
            echo Html::a($jkName[3], ['stream', 'jkId' => 3]);
            echo '</div>';
        }

        if (Stream::find()->andWhere(['jk_id' => 4])->exists()) {
            echo '<div class="col-md-2"">';
            echo Html::a($jkName[4], ['stream', 'jkId' => 4]);
            echo '</div>';
        }

        if (Stream::find()->andWhere(['jk_id' => 5])->exists()) {
            echo '<div class="col-md-2"">';
            echo Html::a($jkName[5], ['stream', 'jkId' => 5]);
            echo '</div>';
        }
        if (Stream::find()->andWhere(['jk_id' => 6])->exists()) {
            echo '<div class="col-md-2"">';
            echo Html::a($jkName[6], ['stream', 'jkId' => 6]);
            echo '</div>';
        }

        ?>
    </div>

    <iframe src="https://ipeye.ru/ipeye_service/api/iframe.php?iframe_player=1&dev=c5e873548b8649978ac38ff1513f4896&autoplay=0&archive=1" width="800" height="600" frameBorder="0" seamless="seamless" allowfullscreen>Ваш браузер не поддерживает фреймы!</iframe>

<?php

echo Html::decode($cameraEdit);

echo Html::decode($stream);


