<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vote_questions_variant".
 *
 * @property int $question_id
 * @property int $variant_id
 *
 * @property VoteQuestions $question
 * @property VoteVariants $variant
 */
class VoteQuestionsVariant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vote_questions_variant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_id', 'variant_id'], 'required'],
            [['question_id', 'variant_id'], 'integer'],
            [['question_id', 'variant_id'], 'unique', 'targetAttribute' => ['question_id', 'variant_id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => VoteQuestions::className(), 'targetAttribute' => ['question_id' => 'id']],
            [['variant_id'], 'exist', 'skipOnError' => true, 'targetClass' => VoteVariants::className(), 'targetAttribute' => ['variant_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'question_id' => 'Question ID',
            'variant_id' => 'Variant ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(VoteQuestions::className(), ['id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariant()
    {
        return $this->hasOne(VoteVariants::className(), ['id' => 'variant_id']);
    }
}
