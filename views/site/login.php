<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \mdm\admin\models\form\Login */

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните форму для входа на сайт:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($model, 'username')->label('Логин') ?>
            <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
            <?= $form->field($model, 'rememberMe')->checkbox()->label('Запомнить меня') ?>
            <div style="color:#999;margin:1em 0">
               <!--Если Вы забыли пароль, то вы можете--> <?//= Html::a('сбросить его', ['site/request-password-reset']) ?>
                Если у Вас нет учетной записи, то Вы можете <?= Html::a('зарегистрироваться', ['site/signup'], ['style'=>'color:red']) ?>. <br/>
                <?=Html::a('Забыли пароль?', 'request-password-reset')?>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
