<?php

namespace app\models;

use Yii;
use app\models\RefDoljnost;

class RefMembers extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ref_members';
    }

    public function rules()
    {
        return[
            [['ref_answer_id', 'doljnost_id', 'count'], 'required'],
            [['ref_answer_id', 'doljnost_id', 'count', 'user_id'], 'integer'],
            [['doljnost_id'], 'unique', 'comboNotUnique'=>'Вы уже добавили такую должность', 'targetAttribute' => ['ref_answer_id', 'doljnost_id']],

        ];
    }

    public function attributeLabels()
    {
        return[
            'doljnost_id' => 'Должность',
            'count' => 'Максимальное количество вакансии на данную должность',
        ];
    }
    public function getDoljnost()
    {
        return $this->hasOne(RefDoljnost::className(), ['id' => 'doljnost_id']);
    }
}
