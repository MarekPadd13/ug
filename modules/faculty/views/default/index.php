<?php

use yii\grid\GridView;

$this->title = $title;
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2><?php echo $this->title ?></h2>


            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'last_name',
                    'first_name',
                    'patronymic',

                    ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
                ],
            ]); ?>

        </div>
    </div>
</div>