<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vote_variants".
 *
 * @property int $id
 * @property string $name текст варианта
 *
 * @property VoteQuestionsVariant[] $voteQuestionsVariants
 * @property VoteQuestions[] $questions
 */
class VoteVariants extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vote_variants';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVoteQuestionsVariants()
    {
        return $this->hasMany(VoteQuestionsVariant::className(), ['variant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(VoteQuestions::className(), ['id' => 'question_id'])->viaTable('vote_questions_variant', ['variant_id' => 'id']);
    }
}
