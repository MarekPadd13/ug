<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dict_chairmans".
 *
 * @property int $id
 * @property string $last_name
 * @property int $first_name
 * @property int $patronymic
 * @property string $position
 *
 * @property Olympiс[] $olympiсs
 */
class DictChairmans extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_chairmans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_name', 'first_name', 'patronymic', 'position'], 'required'],
            [['first_name', 'patronymic', 'last_name', 'position'], 'string', 'max' => 255],
            ['last_name', 'unique', 'targetAttribute' => ['last_name', 'first_name', 'patronymic', 'position']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'last_name' => 'Фамилия',
            'first_name' => 'Имя',
            'patronymic' => 'Отчество',
            'position' => 'Должность',
        ];
    }

    public function getFullName()
    {
        return $this->last_name . ' ' . $this->first_name . $this->patronymic ? ' ' . $this->patronymic : '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOlympiсs()
    {
        return $this->hasMany(Olimpiс::className(), ['chairman_id' => 'id']);
    }
}
