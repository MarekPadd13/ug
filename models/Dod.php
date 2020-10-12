<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dod".
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property string $date
 * @property string $time
 * @property int $faculty_id
 * @property string $adress
 * @property string $slug
 * @property string $photo_report
 *
 * @property DictFaculty $faculty
 * @property MasterClass[] $masterClasses
 * @property UserDod[] $userDods
 */
class Dod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'date_time', 'address'], 'required'],
            [['name', 'address', 'aud_number', 'description'], 'string'],
            [['type', 'faculty_id', 'edu_level'], 'integer'],
            [['date_time'], 'safe'],
            [['slug', 'photo_report'], 'string', 'max' => 255],
            [['aud_number'], 'string', 'max' => 32],
            [['faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictFaculty::className(), 'targetAttribute' => ['faculty_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название мероприятия',
            'description'=> 'Описание',
            'type' => 'Общеуниверситетский день открытых дверей',
            'date_time' => 'Дата и время',
            'faculty_id' => 'Институт/факультет',
            'address' => 'Адрес',
            'photo_report' => 'Ссылка на фотоотчет',
            'edu_level' => 'Уровень образования',
            'aud_number' => 'Номер аудиории',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaculty()
    {
        return $this->hasOne(DictFaculty::className(), ['id' => 'faculty_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMasterClasses()
    {
        return $this->hasMany(MasterClass::className(), ['dod_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserDods()
    {
        return $this->hasMany(UserDod::className(), ['dod_id' => 'id']);
    }
}
