<?php

/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $this yii\web\View */

/** @var $olimpicModel \app\models\Olimpic */

use app\modules\test\models\TestQuestion;
use himiklab\yii2\ajaxedgrid\GridView;

$this->title = 'Банк вопросов';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $olimpicModel->name;

echo '<div class="container">';

GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'title',
        'type',
        'text:html',
        'mark',
        [
            'attribute' => 'group.name',
            'label' => 'Группа'
        ],
    ],
    'addButtons' => [
        'Выбрать вариант(ы)' => ['create', 'typeId' => TestQuestion::TYPE_SELECT, 'olimpicId' => $olimpicModel->id],
        'Выбрать вариант' => ['create', 'typeId' => TestQuestion::TYPE_SELECT_ONE, 'olimpicId' => $olimpicModel->id],
        'Сопоставить' => ['create', 'typeId' => TestQuestion::TYPE_MATCHING, 'olimpicId' => $olimpicModel->id],
        'Кратк¬ий ответ' => ['create', 'typeId' => TestQuestion::TYPE_ANSWER_SHORT, 'olimpicId' => $olimpicModel->id],
        'Развернутый ответ' => ['create', 'typeId' => TestQuestion::TYPE_ANSWER_DETAILED,
            'olimpicId' => $olimpicModel->id],
        'Загрузка файла' => ['create', 'typeId' => TestQuestion::TYPE_FILE, 'olimpicId' => $olimpicModel->id],
    ],
]);

echo '</div>';