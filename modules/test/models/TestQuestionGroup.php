<?php

namespace app\modules\test\models;

use app\models\Olimpic;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "test_question_group".
 *
 * @property int $id ID
 * @property int $olimpic_id Олимпиада
 * @property string $name Имя
 *
 * @property-read TestGroup[] $testGroups
 * @property-read Test[] $tests
 * @property-read TestQuestion[] $testQuestions
 * @property-read Olimpic $olimpic
 */
class TestQuestionGroup extends ActiveRecord
{
    public static function tableName()
    {
        return 'test_question_group';
    }

    public function rules()
    {
        return [
            [['olimpic_id', 'name'], 'required'],
            [['olimpic_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'olimpic_id' => 'Олимпиада',
            'name' => 'Имя',
        ];
    }

    public function getTestGroups()
    {
        return $this->hasMany(TestGroup::className(), ['question_group_id' => 'id']);
    }

    public function getTests()
    {
        return $this->hasMany(Test::className(), ['id' => 'test_id'])
            ->viaTable(TestGroup::tableName(), ['question_group_id' => 'id']);
    }

    public function getTestQuestions()
    {
        return $this->hasMany(TestQuestion::className(), ['group_id' => 'id']);
    }

    public function getOlimpic()
    {
        return $this->hasOne(Olimpic::className(), ['id' => 'olimpic_id']);
    }
}
