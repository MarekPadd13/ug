<?php

namespace app\modules\sending\models;

use Yii;

/**
 * This is the model class for table "poll_poll_answer".
 *
 * @property int $poll_id
 * @property int $poll_answer_id
 *
 * @property DictPollAnswers $pollAnswer
 * @property Polls $poll
 */
class PollPollAnswer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'poll_poll_answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['poll_id', 'poll_answer_id'], 'required'],
            [['poll_id', 'poll_answer_id'], 'integer'],
            [['poll_id', 'poll_answer_id'], 'unique', 'targetAttribute' => ['poll_id', 'poll_answer_id']],
            [['poll_answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictPollAnswers::className(), 'targetAttribute' => ['poll_answer_id' => 'id']],
            [['poll_id'], 'exist', 'skipOnError' => true, 'targetClass' => Polls::className(), 'targetAttribute' => ['poll_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'poll_id' => 'Опрос',
            'poll_answer_id' => 'Варианты ответа',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPollAnswer()
    {
        return $this->hasOne(DictPollAnswers::className(), ['id' => 'poll_answer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoll()
    {
        return $this->hasOne(Polls::className(), ['id' => 'poll_id']);
    }

    public static function hasPollAnswer($id)
    {
        return PollPollAnswer::find()->andWhere(['poll_id'=>$id])->exists();
    }

}
