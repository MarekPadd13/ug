<?php

namespace app\models;

use phpbb\session;
use Yii;

/**
 * This is the model class for table "dict_angle".
 *
 * @property int $id
 * @property string $name
 *
 */
class  DictAngle extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'dict_angle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            ['name', 'unique', 'targetClass' => self::class, 'message' => 'Такой ракурс уже есть в списке'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название ракурса',
        ];
    }

    public static function allColumn() {
        return self::find()->select('name, id')->orderBy(['name'=> SORT_ASC])->indexBy('id')->column();
    }

}
