<?php

namespace app\models;

use Yii;

class RefKomments extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ref_komments';
    }

    public function rules()
    {
        return[
            [['text'], 'required'],
            ['text', 'string'],
            ['moderation', 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return[
            'text' => 'Ваш вариант',
        ];
    }
}