<?php

namespace app\models;

use Yii;
use app\models\DictCountry;
use app\models\DictRegion;

/**
 * This is the model class for table "dict_city".
 *
 * @property int $id
 * @property string $name название города
 * @property int $country страна
 * @property int $region регион
 */
class DictCity extends \yii\db\ActiveRecord
{
   const NEED_MODERATION = 0;
   const ADD_MODERATION = 1;

    public function GetModerationItem()
    {
        return [self::NEED_MODERATION => 'Нет', self::ADD_MODERATION => 'Да'];
   }

    public static function tableName()
    {
        return 'dict_city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'country'], 'required'],
            [['country', 'region', 'moderation'], 'integer'],
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
            'name' => 'Название города',
            'country' => 'Страна',
            'region' => 'Регион для РФ',
            'moderation' => 'Пройдена модерация?',
        ];
    }
    public function getDictCountry()
    {
        return $this->hasOne(DictCountry::className(), ['id' => 'country']);
    }


    public function getDictRegion()
    {
        return $this->hasOne(DictRegion::className(), ['id' => 'region']);
    }

    public static function getCountITemWithoutModeration()
    {
        return self::find()->where(['moderation'=> DictCity::NEED_MODERATION])->count();
    }
}

