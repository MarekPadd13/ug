<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dict_specialization".
 *
 * @property int $id
 * @property string $name
 * @property int $speciality_id
 */
class DictSpecialization extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_specialization';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'speciality_id'], 'required'],
            [['speciality_id'], 'integer'],
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
            'name' => 'Навзвание',
            'speciality_id' => 'Направление подготовки',
            [['name'], 'unique', 'message' => 'Такая образовательная организация уже есть'],
        ];
    }
}
