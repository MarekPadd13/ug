<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dict_class_course".
 *
 * @property int $id
 * @property string $name класс/курс
 */
class DictClassCourse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_class_course';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
            'name' => 'Класс/курс',
        ];
    }
}
