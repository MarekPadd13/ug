<?php
use yii\helpers\Html;
$this->title = $model->h1;
$this->params['breadcrumbs'][] = ['label' => 'Все новости', 'url' => ['all-news']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
	<div class="row">
		<h1><?=$model->h1?></h1>
		<div class="col-md-12">
			<?=$repResult?>


        </div>
	</div>
</div>