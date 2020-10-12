<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vote_questions".
 *
 * @property int $id
 * @property string $name название вопроса
 * @property string $text суть вопроса
 * @property int $type Тип (опрос = 1, опрос с файлом  = 2, голосование 3
 * @property string $extension
 * @property int $moderation
 *
 * @property VoteVariants[] $voteVariants
 */
class VoteQuestions extends \yii\db\ActiveRecord
{

    const TYPENEWS = 0;
    const TYPEQUIZ = 1;
    const TYPEQUIZWITHFILE = 2;
    const TYPEVOTE = 3;

    public function type()
    {
        return [
            '' => '',
            self::TYPENEWS => 'новостная рассылка',
            self::TYPEQUIZ => 'опрос',
            self::TYPEQUIZWITHFILE => 'опрос с загрузкой файла',
            self::TYPEVOTE => 'вопрос на голосование',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vote_questions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'text', 'type'], 'required'],
            ['extension', 'required', 'when' => function ($model) {
                return $model->type == self::TYPEQUIZWITHFILE;
            },
                'whenClient' => 'function(attribute, value){
                    return $("#votequestions-extension").val ==2}'],
            [['text'], 'string'],
            [['type', 'moderation'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['extension'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'text' => 'Суть',
            'type' => 'Тип',
            'extension' => 'Расширение',
            'moderation' => 'Модерация',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVoteVariants()
    {
        return $this->hasMany(VoteVariants::className(), ['vote_questions_id' => 'id']);
    }
}
