<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dict_schools".
 *
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property int $region_id
 *
 * @property DictCountry $country
 * @property DictRegion $region
 * @property UserSchool[] $userSchools
 * @property User[] $users
 */
class DictSchools extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_schools';
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
            [['country_id', 'region_id'], 'integer'],
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
            'country_id' => 'Страна, где расположена учебная организация',
            'region_id' => 'Регион, где расположена учебная организация',
        ];
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_school', ['school_id' => 'id']);
    }
}
