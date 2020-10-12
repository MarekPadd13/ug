<?php

namespace app\models;

use app\modules\test\models\TestAttempt;
use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string $patronymic
 * @property string $phone
 * @property int $country_id
 * @property int $region_id
 * @property int $user_id
 *
 * @property User $user
 */
class Profiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_name', 'first_name', 'phone'], 'required'],
            [['user_id'], 'integer'],
            [['last_name', 'first_name', 'patronymic'], 'string', 'min' => 1, 'max' => 255],
            [['last_name', 'first_name', 'patronymic'], 'match', 'pattern' => '/^[а-яА-Я\-\s]+$/u',
                'message' => 'Значение поля должно содержать только буквы кириллицы пробел или тире'],
            [['phone'], 'string', 'max' => 25],
            ['phone', 'unique', 'message' => 'Такой номер телефона уже зарегистрирован в нашей базе данных'],
            ['phone', 'match', 'pattern' => '/^\+7\(\d{3}\)\d{3}\-\d{2}\-\d{2}$/', 'message' => 'неверный формат телефона!'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'last_name' => 'Фамилия:',
            'first_name' => 'Имя:',
            'patronymic' => 'Отчество:',
            'phone' => 'Номер телефона:',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function shortFio()
    {
        return $this->first_name.' '. mb_substr($this->last_name, 0, 1, 'utf-8').'.';
    }

    public function numHouse()
    {
        return $this->house->name;
    }

    public function phoneForWa()
    {
        return str_replace(array('+', ' ', '(', ')', '-'), '', $this->phone);
    }


    public static function getPhone()
    {
        return Profiles::find()->select('phone')->indexBy('user_id')->column();
    }

    public static function getNameAndPatronymic()
    {
        return Profiles::find()
            ->select(['concat_ws(" ", 	first_name, patronymic)'])
            ->indexBy('user_id')
            ->column();

    }

    public function getCountry()
    {
        return $this->hasOne(DictCountry::className(), ['id' => 'country_id']);
    }

    public function getRegion()
    {
        return $this->hasOne(DictRegion::className(), ['id' => 'region_id']);
    }

    public function getFullName()
    {

        return $this->last_name . " " . $this->first_name . " " . ($this->patronymic ? $this->patronymic : '');

    }

    public static function getFullNameAllProfiles()
    {
        return Profiles::find()
            ->select(['concat_ws(" ", last_name, first_name, patronymic)'])
            ->indexBy('user_id')
            ->column();
    }

    public static function getFullNameProfilesWithLogin()
    {
        return Profiles::find()
            ->joinWith('user')
            ->select(['concat_ws(" ", last_name, first_name, patronymic, user.username)'])
            ->indexBy('user_id')
            ->column();
    }

    public static function existProfile()
    {
        $profile = Profiles::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
        return $profile;

    }

    public function getHouseApart()
    {
        return $this->hasMany(UserHouseApart::className(), ['user_id'=> 'user_id']);
    }

    public function getHouse()
    {
        return $this->hasMany(DictHouses::className(), ['house_id'=> 'id'])->via('houseApart');
    }




}
