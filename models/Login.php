<?php

namespace app\models;

use mdm\admin\models\form\Login as LoginForm;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Login extends LoginForm
{
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня',
        ];


    }
}
