<?php

namespace app\models;

use Yii;

class RefDoljnost extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ref_doljnost';
    }

    public function rules()
    {
        return[
            [['name', 'ball', 'description'], 'required'],
            ['name', 'string', 'max'=>56],
            ['description', 'string'],
            ['name', 'unique', 'message' => "Такая должность имеется в базе данных"],
            [['ball', 'moderation', 'user_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return[
            'name' => 'Название должности',
            'ball' => 'Начисляемый балл за активность',
            'description' => 'Краткое описание должности',
            'moderation' => 'Модерация',
        ];
    }
}