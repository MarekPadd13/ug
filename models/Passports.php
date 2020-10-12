<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "passports".
 *
 * @property int $id
 * @property int $type_id
 * @property string $citizenship
 * @property string $serial
 * @property string $number
 * @property string $issue
 * @property string $date_of_issue
 * @property int $user_id
 *
 * @property User $user
 */
class Passports extends \yii\db\ActiveRecord
{
 const PASSPORT = 1;
 const BIRTH_CERTIFICATE = 2;

    public function GetTypeDoc()
    {
        return [self::PASSPORT => 'Паспорт' , self::BIRTH_CERTIFICATE => 'Свидетельство о рождении'];
    }


    public static function tableName()
    {
        return 'passports';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'citizenship', 'serial', 'number', 'issue', 'date_of_issue', 'user_id'], 'required'],
            [['type_id', 'user_id'], 'integer'],
            [['date_of_issue'], 'safe'],

            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Выберите тип документа',
            'citizenship' => 'Гражданство',
            'serial' => 'Серия документа',
            'number' => 'Номер документа',
            'issue' => 'Кем выдан',
            'date_of_issue' => 'Дата выдачи',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
