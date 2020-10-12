<?php

namespace app\modules\sending\models;

use Yii;

/**
 * This is the model class for table "polls".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 *
 * @property PollPollAnswer[] $pollPollAnswers
 * @property DictPollAnswers[] $pollAnswers
 * @property SendingsPolls[] $sendingsPolls
 * @property Sending[] $sendings
 */
class Polls extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'polls';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
            ['title', 'unique', 'message'=>'Такой заголовок уже существует'],
            [['content'], 'unique', 'targetAttribute'=> ['title', 'content'], 'message'=> 'Такой опрос уже существует'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'content' => 'Вопрос',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPollPollAnswers()
    {
        return $this->hasMany(PollPollAnswer::className(), ['poll_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPollAnswers()
    {
        return $this->hasMany(DictPollAnswers::className(), ['id' => 'poll_answer_id'])->viaTable('poll_poll_answer', ['poll_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSendingsPolls()
    {
        return $this->hasMany(SendingsPolls::className(), ['poll_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSendings()
    {
        return $this->hasMany(Sending::className(), ['id' => 'sending_id'])->viaTable('sendings_polls', ['poll_id' => 'id']);
    }

    public static function getAllPolls()
    {
        return Polls::find()->select('title')->indexBy('id')->column();
    }
}
