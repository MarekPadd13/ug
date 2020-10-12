<?php

use yii\helpers\Html;

/**
 * @var $vote
 */


$this->title = 'Текущие голосования и опросы';
$this->params['breadcrumbs'][] = $this->title;

$dictAnswers = \app\modules\sending\models\DictPollAnswers::getAllItems();

?>

<?php
$result = '';
$c = 0;
foreach ($vote as $userVote) {
    $sending = \app\modules\sending\models\Sending::find()->andWhere(['poll_id' => $userVote->id])->one();

    if (!$sending) {
        continue;
    }

    if ($c % 3 == 0) {
        $result .= '<div class="row">';
    }

    $result .= '<div class="col-md-4">';
    $result .= '<h3>' . $userVote->title . '</h3>';

    foreach ($userVote->answers as $answer) {
        $result .= $dictAnswers[$answer->poll_answer_id]
            . ' - '
            .\app\modules\sending\models\SendingDeliveryStatus::countVote($sending->poll_id, $answer->poll_answer_id)
            . '<br/>';
    }


    $result .= '</div>';
    if ($c % 3 == 2) {
        $result .= '</div>';
    }

    $c++;

}
?>

<?= $result ?>

</div>
