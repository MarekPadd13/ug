<?php
/**
 * Created by PhpStorm.
 * User: ramil
 * Date: 12.10.2018
 * Time: 11:42
 */

namespace app\models;

use Yii;
use yii\base\Model;


class RegistrationDod extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repetition;
    public $verifyCode;
    public $lastname;
    public $firstname;
    public $patronymic;
    public $phone;
    public $countryId;
    public $regionId;
    public $masterClassId = null;
    public $agree;

    public function rules()
    {
        return [
            [['lastname', 'firstname', 'phone', 'countryId'], 'required'],
            ['agree', 'required', 'requiredValue' => true, 'message'=> 'Согласитесь, пожалуйста, с обработкой персональных данных, 
            поставив соответствующую "галочку"'],

            [['lastname', 'firstname', 'patronymic'], 'match', 'pattern' => '/^[а-яА-Я]+$/u',
                'message'=> 'Значение поля должно содержать только буквы кириллицы'],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'mdm\admin\models\User', 'message' => 'Такой пользоватль уже существует.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'match', 'pattern'=> '/^[^\%\$\&\,\?\"\(\)\'!а-яА-Я]+$/u',
                'message'=> 'Поле не может содержать символы кириллицы и спецсимволы %, $, &, запятые, кавычки и скобки'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'mdm\admin\models\User', 'message' => 'Этот email уже зарегистрирован в системе.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repetition', 'compare', 'compareAttribute' => 'password'],
            ['verifyCode', 'captcha'],

            ['phone', 'unique', 'targetClass'=> 'app\models\Profiles', 'message' => 'Такой номер телефона уже зарегистрирован в нашей базе данных'],
            ['phone', 'match', 'pattern' => '/^\+7\(\d{3}\)\d{3}\-\d{2}\-\d{2}$/', 'message' => 'неверный формат телефона!' ],


            ['regionId', 'required', 'when'=> function($model){
                return $model->countryId == 46;},
                'whenClient'=> 'function (attribute, value)
                {
            return $("#registrationdod-countryid").val() == 46}'],

            [['regionId'], 'integer'],
            ['patronymic', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Придумайте логин для личного кабинета (это может быть ваш email)',
            'email' => 'Адрес электронной почты:',
            'password' => 'Придумайте пароль',
            'password_repetition' => 'Повтор пароля',
            'lastname' => 'Фамилия',
            'firstname' => 'Имя',
            'patronymic' => 'Отчество',
            'phone' => 'Номер телефона',
            'countryId' => 'Страна проживания',
            'regionId' => 'Регион проживания',
            'masterClassId' => 'Мастер-классы',
            'verifyCode' => 'Введите код с картинки',
            'agree' => 'Я согласен (согласна) на обработку моих персональных данных',
        ];
    }

    public function save($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $userModel = new User();
            $userModel->username = $this->username;
            $userModel->email = $this->email;
            $userModel->setPassword($this->password);
            $userModel->generateAuthKey();
            if (!$userModel->save()) {
                throw new \Exception('Ошибка в коде не удалось создать пользователя. ' .
                    print_r($userModel->errors, true));
            }

            $profileModel = new Profiles();
            $profileModel->user_id = $userModel->id;
            $profileModel->last_name = $this->lastname;
            $profileModel->first_name = $this->firstname;
            $profileModel->patronymic = $this->patronymic;
            $profileModel->phone = $this->phone;
            $profileModel->country_id = $this->countryId;
            $profileModel->region_id = $this->regionId;
            if (!$profileModel->save()) {
                throw new \Exception('Профиль не сохранился. ошибка в коде. ' .
                    print_r($profileModel->errors, true));
            }

            $dodModel = new UserDod();
            $dodModel->user_id = $userModel->id;
            $dodModel->dod_id = $id;
            if (!$dodModel->save()) {
                throw new \Exception('запись на ДОД не сохранилась. ошибка в коде. ' .
                    print_r($dodModel->errors, true));
            }

            if ($this->masterClassId) {
                $masterClass = MasterClass::find()->andWhere(['dod_id' => $id]);
                if (isset($masterClass)) {
                    $masterClassModel = new UserMasterClass();
                    $masterClassModel->user_id = $userModel->id;
                    $masterClassModel->master_class_id = $this->masterClassId;
                    if (!$masterClassModel->save()) {
                        throw new \Exception('запись на мастер - класс не сохранилась. ошибка в коде. ' .
                            print_r($masterClassModel->errors, true));
                    }
                }
            }

        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        $transaction->commit();
        return $userModel->id;
    }


}