<?php
/**
 * Created by PhpStorm.
 * User: ramil
 * Date: 20/11/2018
 * Time: 10:52
 */

namespace app\models;


class Templates extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'templates';
    }

    public function rules()
    {
        return [
            [['type_id', 'name', 'text', 'name_for_user'], 'required'],
            ['type_id', 'integer'],
            [['text', 'name', 'name_for_user'], 'string'],
            [['text'], 'unique', 'targetAttribute' => ['type_id', 'text']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'type_id' => 'Тип шаблона',
            'name' => 'Название шаблона',
            'text' => 'Текст шаблона',
            'name_for_user'=> 'Название для отображения на сайте',

        ];
    }

    public static function typeTemplates()
    {
        return [
            '1' => 'Для олимпиад',
            '2' => 'Для документов цпк',
        ];
    }


}
