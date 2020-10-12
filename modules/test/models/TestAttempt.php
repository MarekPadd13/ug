<?php

namespace app\modules\test\models;

use app\models\User;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "test_attempt".
 *
 * @property int $id ID
 * @property int $user_id Пользователь
 * @property string $start Начало
 * @property string $end Окончание
 * @property int $test_id Тест
 * @property double $mark Результат
 *
 * @property-read User $user
 * @property-read Test $test
 * @property-read TestResult[] $results
 * @property-read TestQuestion[] $questions
 */
class TestAttempt extends ActiveRecord
{
    public static function tableName()
    {
        return 'test_attempt';
    }

    public function rules()
    {
        return [
            [['user_id', 'test_id'], 'required'],
            [['user_id', 'test_id'], 'integer'],
            [['start', 'end'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['user_id', 'test_id'], 'unique', 'targetAttribute' => ['user_id', 'test_id']],
            ['mark', 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'start' => 'Начало',
            'end' => 'Окончание',
            'test_id' => 'Тест',
            'mark' => 'Результат',
        ];
    }

    /**
     * Пересчитываем результат.
     *
     * @return double|null
     */
    public function evulate()
    {
        if (TestResult::find()
            ->joinWith(['question'], false)
            ->andWhere(['attempt_id' => $this->id])
            ->andWhere(['in', TestQuestion::tableName() . '.type_id', [
                TestQuestion::TYPE_ANSWER_DETAILED,
                TestQuestion::TYPE_FILE,
            ]])
            ->andWhere([TestResult::tableName() . '.mark' => null])
            ->exists()
        ) {
            return null;
        }

        $markSum = 0;
        foreach ($this->results as $currentResult) {
            $question = $currentResult->question;
            if ($currentResult->mark) {
                $markSum += $currentResult->mark;
                continue;
            }
            if (empty($currentResult->resultArray)) {
                continue;
            }

            switch ($question->type_id) {
                case TestQuestion::TYPE_SELECT:
                    $mark = 0;
                    $correctCount = 0;
                    $correctIndexes = [];
                    foreach ($question->optionsArray['isCorrect'] as $index) {
                        $correctIndexes[] = $index;
                        ++$correctCount;
                    }

                    if ($correctCount === 0) {
                        continue 2;
                    }
                    $markPerVariant = $question->mark / $correctCount;

                    foreach ($currentResult->resultArray as $currentResultIndex) {
                        if (\in_array($currentResultIndex, $correctIndexes)) {
                            $mark += $markPerVariant;
                        } else {
                            $mark -= $markPerVariant;
                        }
                    }

                    $mark = \round($mark, 2);
                    if ($mark < 0) {
                        $mark = 0;
                    }
                    $markSum += $mark;
                    break;

                case TestQuestion::TYPE_MATCHING:
                    if (!empty($currentResult->resultArray)) {
                        $mark = 0;
                        $markPerVariant = $question->mark / \count($currentResult->resultArray);
                        foreach ($currentResult->resultArray as $index => $value) {
                            if ($index == $value) {
                                $mark += $markPerVariant;
                            } else {
                                $mark -= $markPerVariant;
                            }
                        }

                        $mark = \round($mark, 2);
                        if ($mark < 0) {
                            $mark = 0;
                        }
                        $markSum += $mark;
                    }
                    break;

                case TestQuestion::TYPE_ANSWER_SHORT:
                    $resultText = \mb_strtolower(\trim($currentResult->resultArray[0]), 'UTF-8');
                    if (\in_array($resultText, $question->optionsArray)) {
                        $markSum += $question->mark;
                    }
                    break;

                case TestQuestion::TYPE_SELECT_ONE:
                    if (!empty($currentResult->resultArray) &&
                        $currentResult->resultArray[0] == $question->optionsArray['isCorrect'][0]
                    ) {
                        $markSum += $question->mark;
                    }
                    break;
            }
        }

        $testMaxMark = $this->getQuestions()->sum('mark');
        $markSum = ($testMaxMark ? \round($markSum / $testMaxMark * 100, 2) : null);
        $this->mark = $markSum;
        $this->save();

        return $markSum;
    }

    /**
     * Количество вопросов в попытке.
     *
     * @return int
     */
    public function getQuestionsCount()
    {
        return TestResult::find()
            ->andWhere(['attempt_id' => $this->id])
            ->count();
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getTest()
    {
        return $this->hasOne(Test::className(), ['id' => 'test_id']);
    }

    public function getResults()
    {
        return $this->hasMany(TestResult::className(), ['attempt_id' => 'id']);
    }

    public function getQuestions()
    {
        return $this->hasMany(TestQuestion::className(), ['id' => 'question_id'])
            ->viaTable(TestResult::tableName(), ['attempt_id' => 'id']);
    }
}
