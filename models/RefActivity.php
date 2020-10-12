<?php

namespace app\models;

use Yii;

class RefActivity extends yii\db\ActiveRecord
{
    const VOITING_FOR_ANSWER = 10;
    const VOITING_FOR_PROBLEM = 10;
    const GET_ANSWER = 100;
    const GET_PROBLEM = 50;

    public static function tableName()
    {
        return 'ref_activity';
    }

    public function rules()
    {
        return[
            [['user_id','ball', 'type_of_action_id', 'ref_answer_id', 'ref_problems_id'], 'integer'],
            [['user_id', 'ref_answer_id'], 'unique'],
            [['user_id', 'ref_problems_id'], 'unique'],

        ];
    }

    public function attributeLabels()
    {
        return[
            'ball' => 'балл за действие',

        ];
    }
}