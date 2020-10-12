<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dict_schools_pre_moderation".
 *
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property int $region_id
 * @property int $dict_school_id
 *
 * @property DictSchools $dictSchool
 * @property DictCountry $country
 * @property DictRegion $region
 * @property UserSchool[] $userSchools
 */
class DictSchoolsPreModeration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_schools_pre_moderation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'country_id'], 'required'],
            [['name'], 'string'],
            ['name', 'unique', 'message'=> 'Такая учебная организация уже есть в справочнике'],
            [['country_id', 'region_id', 'dict_school_id'], 'integer'],
            [['dict_school_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictSchools::className(), 'targetAttribute' => ['dict_school_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictCountry::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictRegion::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название учебной организации',
            'country_id' => 'Страна',
            'region_id' => 'Регион',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictSchool()
    {
        return $this->hasOne(DictSchools::className(), ['id' => 'dict_school_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(DictCountry::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(DictRegion::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSchools()
    {
        return $this->hasMany(UserSchool::className(), ['school_id' => 'id']);
    }
}
