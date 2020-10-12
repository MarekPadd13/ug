<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dict_discipline".
 *
 * @property int $id
 * @property string $name
 * @property string $links
 */
class DictDiscipline extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_discipline';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'unique', 'message'=> 'Такая дисциплина уже есть в справочнике'],
            [['name', 'links'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название дисциплины',
            'links' => 'Ссылка на сайте',
        ];
    }
}
