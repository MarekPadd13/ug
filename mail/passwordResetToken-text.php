<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user mdm\admin\models\User */

$resetLink = Url::to(['site/reset-password','token'=>$user->password_reset_token], true);
?>
Здравствуйте, <?= $user->username ?>,

Проследуйте по ссылке для восстановления пароля:

<?= $resetLink ?>
