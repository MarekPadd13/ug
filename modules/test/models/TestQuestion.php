<?php

namespace app\modules\test\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "test_question".
 *
 * @property int $id ID
 * @property int $group_id Группа вопросов
 * @property int $type_id Тип вопроса
 * @property string $title Заголовок
 * @property string $text Вопрос
 * @property double $mark Сумма первичных баллов
 * @property-read string $options Варианты
 * @property-read int $file_type_id Тип файла
 *
 * @property-read TestQuestionGroup $group
 * @property-read TestResult[] $testResults
 * @property-read TestAttempt[] $attempts
 * @property-read string $type
 */
class TestQuestion extends ActiveRecord
{
    public $optionsArray = [];

    const TYPE_SELECT = 1;
    const TYPE_MATCHING = 2;
    const TYPE_ANSWER_SHORT = 3;
    const TYPE_ANSWER_DETAILED = 4;
    const TYPE_FILE = 5;
    const TYPE_SELECT_ONE = 6;

    const FILE_TYPE_IMAGE = 1;
    const FILE_TYPE_TEXT = 2;
    const FILE_TYPE_MEDIA = 3;

    const FILE_VALIDATE_RULES = [
        self::FILE_TYPE_IMAGE => [
            'extensions' => 'bmp, jpg, png, pdf, tif, gif',
            'maxSize' => 20 * 1024 * 1024,
        ],
        self::FILE_TYPE_TEXT => [
            'extensions' => 'doc, docx, pdf, txt, rtf',
            'maxSize' => 5 * 1024 * 1024,
        ],
        self::FILE_TYPE_MEDIA => [
            'extensions' => 'docx, ppt, pptx, pptm, mp3, wav, mpeg, avi',
            'maxSize' => 25 * 1024 * 1024,
        ],
    ];

    public static function tableName()
    {
        return 'test_question';
    }

    public function rules()
    {
        return [
            [['group_id', 'type_id', 'title', 'mark', 'text'], 'required'],
            ['file_type_id', 'required', 'when' => function ($model) {
                /** @var self $model */
                return $model->type_id == $model::TYPE_FILE;
            },
                'whenClient' =>
                    'function (attribute, value) {return $("#testquestion-type_id").val() == ' .
                    self::TYPE_FILE . ';}'],
            ['optionsArray', 'required', 'when' => function ($model) {
                /** @var self $model */
                return $model->type_id == $model::TYPE_SELECT ||
                    $model->type_id == $model::TYPE_SELECT_ONE ||
                    $model->type_id == $model::TYPE_MATCHING ||
                    $model->type_id == $model::TYPE_ANSWER_SHORT;
            },
                'whenClient' =>
                    'function (attribute, value) {var typeId = $("#testquestion-type_id").val(); return ' .
                    'typeId == ' . self::TYPE_SELECT . ' || ' .
                    'typeId == ' . self::TYPE_SELECT_ONE . ' || ' .
                    'typeId == ' . self::TYPE_MATCHING . ' || ' .
                    'typeId == ' . self::TYPE_ANSWER_SHORT . ';}'],

            [['type_id', 'file_type_id'], 'integer'],
            [['mark'], 'number', 'max' => 100, 'min' => 0.1, 'numberPattern' => '/^\d{1,3}(\.\d)?$/'],
            [['options'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['text'], 'string'],
            ['optionsArray', 'validateOptionsArray'],
        ];
    }

    public function validateOptionsArray($attribute, $params)
    {
        if ($this->hasErrors()) {
            return;
        }

        if ($this->type_id == self::TYPE_ANSWER_SHORT) {
            if (\count(\array_filter($this->{$attribute})) === 0) {
                $this->addError(
                    $attribute,
                    'Необходимо указать правильные ответы.'
                );
            }
        }

        if ($this->type_id == self::TYPE_SELECT || $this->type_id == self::TYPE_SELECT_ONE) {
            if (!isset($this->{$attribute}['isCorrect'])) {
                $this->addError(
                    $attribute,
                    'Необходимо указать правильные ответы.'
                );
                return;
            }

            foreach ($this->{$attribute}['isCorrect'] as $correctIndex) {
                if ($this->{$attribute}['text'][$correctIndex] === '') {
                    $this->addError(
                        $attribute,
                        'Правильный ответ не должен быть пустым.'
                    );
                    return;
                }
            }
        }

        if ($this->type_id == self::TYPE_SELECT) {
            if (\count($this->{$attribute}['isCorrect']) !== \count(\array_filter($this->{$attribute}['text'])) / 2) {
                $this->addError(
                    $attribute,
                    'Необходимо чтобы количество правильных ответов было равно количеству неправильных ответов.'
                );
            }
            return;
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Группа вопросов',
            'type_id' => 'Тип вопроса',
            'title' => 'Заголовок',
            'text' => 'Вопрос',
            'mark' => 'Сумма первичных баллов',
            'options' => 'Варианты',
            'file_type_id' => 'Загружаемый тип файла',

            'type' => 'Тип вопроса',
            'optionsArray' => 'Варианты',
        ];
    }

    public static function getAllTypes()
    {
        return [
            self::TYPE_SELECT => 'Выбрать вариант(ы)',
            self::TYPE_SELECT_ONE => 'Выбрать вариант',
            self::TYPE_MATCHING => 'Сопоставить',
            self::TYPE_ANSWER_SHORT => 'Краткий ответ',
            self::TYPE_ANSWER_DETAILED => 'Развернутый ответ',
            self::TYPE_FILE => 'Загрузка файла',
        ];
    }

    public static function getAllFileTypes()
    {
        return [
            self::FILE_TYPE_IMAGE => 'Изображение',
            self::FILE_TYPE_TEXT => 'Текст',
            self::FILE_TYPE_MEDIA => 'Мультимедиа',
        ];
    }

    public function afterFind()
    {
        $this->optionsArray = $this->options ? \json_decode($this->options, true) : [];

        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->type_id == self::TYPE_ANSWER_SHORT) {
            \array_walk($this->optionsArray, function (&$value) {
                $value = \mb_strtolower(\trim($value), 'UTF-8');
            });
        }
        $this->options = \json_encode($this->optionsArray);

        return true;
    }

    public function getGroup()
    {
        return $this->hasOne(TestQuestionGroup::className(), ['id' => 'group_id']);
    }

    public function getTestResults()
    {
        return $this->hasMany(TestResult::className(), ['question_id' => 'id']);
    }

    public function getAttempts()
    {
        return $this->hasMany(TestAttempt::className(), ['id' => 'attempt_id'])
            ->viaTable(TestResult::tableName(), ['question_id' => 'id']);
    }

    public function getType()
    {
        return self::getAllTypes()[$this->type_id] ?? '';
    }
}
