<?php

namespace app\modules\test\models;

use app\models\DictClass;
use app\models\Olimpic;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "test_class".
 *
 * @property int $test_id Тест
 * @property int $class_id Класс
 *
 * @property-read Test $test
 * @property-read DictClass $class
 */
class TestClass extends ActiveRecord
{
    public static function tableName()
    {
        return 'test_class';
    }

    public function rules()
    {
        return [
            [['test_id', 'class_id'], 'required'],
            [['test_id', 'class_id'], 'integer'],
            [['test_id', 'class_id'], 'unique', 'targetAttribute' => ['test_id', 'class_id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'test_id' => 'Тест',
            'class_id' => 'Класс',
        ];
    }

    public function getTest()
    {
        return $this->hasOne(Test::className(), ['id' => 'test_id']);
    }

    public function getOlimpic()
    {
        return $this->hasOne(Olimpic::className(), ['id' => 'olimpic_id'])->via('test');
    }


    public function getClass()
    {
        return $this->hasOne(DictClass::className(), ['id' => 'class_id']);
    }
}
