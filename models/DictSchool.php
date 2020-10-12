<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dict_school".
 *
 * @property int $id
 * @property string $name название школы
 * @property int $dict_city_id id города
 * @property int $moderation модерация
 * @property int $user_id id пользователя
 *
 * @property Profiles[] $profiles
 */
class DictSchool extends \yii\db\ActiveRecord
{
    const NEED_MODERATION = 0;
    const ADD_MODERATION = 1;

    public function GetModerationItem()
    {
        return [self::NEED_MODERATION => 'Нет', self::ADD_MODERATION => 'Да'];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_school';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'dict_city_id'], 'required'],
            ['name','unique', 'targetClass'=>'app\models\DictSchool', 'message' => 'Такая учебная организация уже присутствует в списке выбора, пожалуйста, вернитесь на предыдущую страницу и выберите ееё 1.'],
            [['dict_city_id', 'moderation'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование учебной организации',
            'dict_city_id' => 'Город, где расположена учебная организация ',
            'moderation' => 'Пройдена ли модерация?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profiles::className(), ['dict_school_id' => 'id']);
    }

    public function getDictCity()
    {
        return $this->hasOne(DictCity::className(),['id' =>'dict_city_id']);
    }
}
