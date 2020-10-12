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


class RegistrationOlimpiads extends Model
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
    public $schoolId;
    public $classId;
    public $agree;

    public function rules()
    {
        return [
            [['lastname', 'firstname', 'phone', 'countryId', 'schoolId', 'classId'], 'required'],
            ['agree', 'required', 'requiredValue' => true, 'message' => 'Согласитесь, пожалуйста, с обработкой персональных данных, 
            поставив соответствующую "галочку"'],

            [['lastname', 'firstname', 'patronymic'], 'match', 'pattern' => '/^[а-яА-Я\-\s]+$/u',
                'message' => 'Значение поля должно содержать только буквы кириллицы пробел и тире'],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'mdm\admin\models\User', 'message' => 'Такой пользователь уже существует.'],
            ['username', 'string', 'min' => 5, 'max' => 255],
            ['username', 'match', 'pattern' => '/^[^\%\$\&\,\?\"\(\)\'!а-яА-Я]+$/u',
                'message' => 'Поле не может содержать символы кириллицы и спецсимволы %, $, &, запятые, кавычки и скобки'],
            ['classId', 'olympClasses'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'mdm\admin\models\User', 'message' => 'Этот email уже зарегистрирован в системе.'],

            ['phone', 'unique', 'targetClass' => 'app\models\Profiles', 'message' => 'Такой номер телефона уже зарегистрирован в нашей базе данных'],
            ['phone', 'match', 'pattern' => '/^\+7\(\d{3}\)\d{3}\-\d{2}\-\d{2}$/', 'message' => 'неверный формат телефона!'],


            ['regionId', 'required', 'when' => function ($model) {
                return $model->countryId == 46;
            },
                'whenClient' => 'function (attribute, value)
                {
            return $("#registrationolimpiads-countryid").val() == 46}'],


            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repetition', 'compare', 'compareAttribute' => 'password'],
            ['verifyCode', 'captcha'],

            [['regionId', 'schoolId', 'classId', 'countryId'], 'integer'],
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
            'schoolId' => 'Выберите образовательную организацию, в которой Вы обучаетесь (обучались)',
            'classId' => 'Выберите текущий класс/курс',
            'verifyCode' => 'Введите код с картинки',
            'agree' => 'Я согласен (согласна) на обработку моих персональных данных',
        ];
    }






    public function save($id, $new_school = null)
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

            $schoolModel = new UserSchool();
            $schoolModel->user_id = $userModel->id;
            if ($new_school) {
                $schoolModel->school_id = $new_school;
            } else {
                $schoolModel->school_id = $this->schoolId;
            }
            $schoolModel->class_id = $this->classId;

            if (!$schoolModel->save()) {
                throw new \Exception('Образовательная организация пользователя не сохраненаю '
                    . print_r($schoolModel->errors, true));
            }

            $olimpModel = new UserOlimpiads();
            $olimpModel->user_id = $userModel->id;
            $olimpModel->olympiads_id = $id;
            if (!$olimpModel->save()) {
                throw new \Exception('запись на олимпиаду/конкурс не сохранилась. ошибка в коде. ' .
                    print_r($olimpModel->errors, true));
            }


        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        $transaction->commit();
        return $userModel->id;
    }


    public function olympClasses()
    {
        if (!ClassAndOlympic::find()
            ->andWhere(['olympic_id' => Yii::$app->request->get('id')])
            ->andWhere(['class_id'=>$this->classId])
            ->exists()) {
            $this->addError('classId','Вы не можете принимать участие в олимпиаде, 
            так как Ваш класс/курс не соответствует требуемым в положении олимпиады');
        }
    }


}