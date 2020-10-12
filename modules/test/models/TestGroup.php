<?php

namespace app\modules\test\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "test_group".
 *
 * @property int $test_id Тест
 * @property int $question_group_id Группа вопросов
 *
 * @property-read TestQuestionGroup $questionGroup
 * @property-read Test $test
 */
class TestGroup extends ActiveRecord
{
    public static function tableName()
    {
        return 'test_group';
    }

    public function rules()
    {
        return [
            [['test_id', 'question_group_id'], 'required'],
            [['test_id', 'question_group_id'], 'integer'],
            [['test_id', 'question_group_id'], 'unique', 'targetAttribute' => ['test_id', 'question_group_id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'test_id' => 'Тест',
            'question_group_id' => 'Группа вопросов',
        ];
    }

    public function getQuestionGroup()
    {
        return $this->hasOne(TestQuestionGroup::className(), ['id' => 'question_group_id']);
    }

    public function getTest()
    {
        return $this->hasOne(Test::className(), ['id' => 'test_id']);
    }
}
