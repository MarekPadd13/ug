<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vote_result".
 *
 * @property int $user_id
 * @property int $vote_question_id
 * @property int $vote_variant_id
 */
class VoteResult extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vote_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'vote_question_id', 'vote_variant_id'], 'required'],
            [['user_id', 'vote_question_id', 'vote_variant_id'], 'integer'],
            [['user_id', 'vote_question_id', 'vote_variant_id'], 'unique', 'targetAttribute' => ['user_id', 'vote_question_id', 'vote_variant_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'vote_question_id' => 'Vote Question ID',
            'vote_variant_id' => 'Vote Variant ID',
        ];
    }
}
