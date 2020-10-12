<?php

namespace app\models;

use mdm\admin\models\form\Signup as SignUpForm;

class Signup extends SignUpForm
{
    public $verifyCode;
    public $agree;
    public $retypePassword;

    public function AttributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'Почта',
            'password' => 'Пароль',
            'retypePassword'=> 'Повторить пароль',
            'verifyCode' => 'Введите код с картинки',
            'agree' => 'Я согласен (согласна) на обработку моих персональных данных',
        ];

    }

    public function rules()
    {
        return array_merge(parent::rules(),
            [
                ['verifyCode', 'captcha'],
                ['agree', 'required', 'requiredValue' => true, 'message'=> 'Согласитесь, пожалуйста, с обработкой персональных данных, 
            поставив соответствующую "галочку"'],
            ]
        );
    }


}