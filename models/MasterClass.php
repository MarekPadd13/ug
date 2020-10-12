<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_class".
 *
 * @property int $id
 * @property string $name
 * @property int $master_id
 * @property string $aud_number
 * @property string $time_start
 * @property string $time_finish
 * @property int $dod_id
 *
 * @property Masters $master
 * @property Dod $dod
 * @property UserMasterClass[] $userMasterClasses
 */
class MasterClass extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_class';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'master_id', 'aud_number', 'time_start', 'time_finish', 'dod_id'], 'required'],
            [['name'], 'string'],
            [['master_id', 'dod_id'], 'integer'],
            [['time_start', 'time_finish'], 'safe'],
            [['aud_number'], 'string', 'max' => 32],
            [['master_id'], 'exist', 'skipOnError' => true, 'targetClass' => Masters::className(), 'targetAttribute' => ['master_id' => 'id']],
            [['dod_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dod::className(), 'targetAttribute' => ['dod_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название мастер-класса',
            'master_id' => 'Ведущий мастер-класса',
            'aud_number' => 'Номер аудитории',
            'time_start' => 'Время начала',
            'time_finish' => 'Время окончания',
            'dod_id' => 'Мастер класс будет проходить на мероприятии',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaster()
    {
        return $this->hasOne(Masters::className(), ['id' => 'master_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDod()
    {
        return $this->hasOne(Dod::className(), ['id' => 'dod_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserMasterClasses()
    {
        return $this->hasMany(UserMasterClass::className(), ['master_class_id' => 'id']);
    }
}
