<?php

namespace app\models;

use Yii;

class RefAnswer extends \yii\db\ActiveRecord
{
    const WITHOUT_MUNICIPAL_LEVEL = false;

    public static function tableName()
    {
        return 'ref_answer';
    }

    public function rules()
    {
        return[
            [['name', 'content', 'ref_problems_id', 'date_start', 'description'], 'required'],
            [['date_start', 'date_finish'], 'safe'],
            [['legasy_status', 'type', 'ref_problems_id', 'author_id'], 'integer'],
            [['name', 'content'], 'string'],
            ['description', 'string', 'max'=>2048],
        ];
    }

    public function attributeLabels()
    {
        return[
            'name' => 'Краткий заголовок',
            'content' => 'Все подробности решения',
            'type' => 'Решение проблемы подразумевает следующий тип действий',
            'description' => 'Суть решения (до 2048 символов)',
        ];
    }

    public function getMembers()
    {
        return $this->hasMany(RefMembers::className(), [ 'ref_answer_id' => 'id']);
    }
}