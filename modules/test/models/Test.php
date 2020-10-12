<?php

namespace app\modules\test\models;

use app\models\ClassAndOlympic;
use app\models\DictClass;
use app\models\Olimpic;
use app\models\User;
use himiklab\yii2\common\MultipleListBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "test".
 *
 * @property int $id ID
 * @property int $olimpic_id Олимпиада
 * @property string $introduction Вступление
 * @property string $final_review Итоговый отзыв
 *
 * @property-read Olimpic $olimpic
 * @property-read TestAttempt[] $testAttempts
 * @property-read User[] $users
 * @property-read TestClass[] $testClasses
 * @property-read DictClass[] $classes
 * @property-read TestGroup[] $testGroups
 * @property-read TestQuestionGroup[] $questionGroups
 */
class Test extends ActiveRecord
{
    public static function tableName()
    {
        return 'test';
    }

    public function behaviors()
    {
        return [
            [
                'class' => MultipleListBehavior::class,
                'relations' => [
                    'classes' => [
                        'type' => MultipleListBehavior::RELATION_TYPE_JUNCTION,
                        'attribute' => TestClass::class
                    ],
                ],
            ],
            [
                'class' => MultipleListBehavior::class,
                'relations' => [
                    'questionGroups' => [
                        'type' => MultipleListBehavior::RELATION_TYPE_JUNCTION,
                        'attribute' => TestGroup::class
                    ],
                ],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['olimpic_id'], 'required'],
            [['olimpic_id'], 'integer'],
            [['introduction', 'final_review'], 'string'],

            [['classesList'], 'required'],
            [['classesList'], 'validateClassesList'],
            ['questionGroupsList', 'safe'],
        ];
    }

    public function validateClassesList($attribute, $params)
    {
        if ($this->hasErrors()) {
            return;
        }

        $query = TestClass::find()
            ->joinWith(['test'], false)
            ->andWhere([self::tableName() . '.olimpic_id' => $this->olimpic_id])
            ->andWhere(['in', 'class_id', $this->{$attribute}]);
        if ($this->id) {
            $query->andWhere(['<>', TestClass::tableName() . '.test_id', $this->id]);
        }

        if ($query->exists()) {
            $this->addError($attribute, 'Множество классов тестов в рамках одной олимпиады пересекаться не могут.');
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'olimpic_id' => 'Олимпиада',
            'introduction' => 'Вступление',
            'final_review' => 'Итоговый отзыв',

            'classesList' => 'Классы',
            'questionGroupsList' => 'Группы вопросов',
        ];
    }

    /**
     * Доступные для данного теста классы
     *
     * @return array
     */
    public function allowedClasses()
    {

        $typeClasses = DictClass::typeOfClass();
        return ArrayHelper::map(ClassAndOlympic::find()
            ->joinWith(['class'])
            ->andWhere(['olympic_id' => $this->olimpic_id])
            ->all(), 'class_id', function ($model) use ($typeClasses) {
            return $model->class->name . '-й ' . $typeClasses[$model->class->type];
        });

    }

    /**
     * Доступные для данного теста группы вопросов
     *
     * @return array
     */
    public function allowedGroups()
    {
        return TestQuestionGroup::find()
            ->andWhere(['olimpic_id' => $this->olimpic_id])
            ->select('name')
            ->indexBy('id')
            ->column();
    }

    public function getOlimpic()
    {
        return $this->hasOne(Olimpic::className(), ['id' => 'olimpic_id']);
    }

    public function getTestAttempts()
    {
        return $this->hasMany(TestAttempt::className(), ['test_id' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable(TestAttempt::tableName(), ['test_id' => 'id']);
    }

    public function getTestClasses()
    {
        return $this->hasMany(TestClass::className(), ['test_id' => 'id']);
    }

    public function getClasses()
    {
        return $this->hasMany(DictClass::className(), ['id' => 'class_id'])
            ->viaTable(TestClass::tableName(), ['test_id' => 'id']);
    }

    public function getTestGroups()
    {
        return $this->hasMany(TestGroup::className(), ['test_id' => 'id']);
    }

    public function getQuestionGroups()
    {
        return $this->hasMany(TestQuestionGroup::className(), ['id' => 'question_group_id'])
            ->viaTable(TestGroup::tableName(), ['test_id' => 'id']);
    }
}
