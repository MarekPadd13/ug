<?php

namespace app\models;

use app\modules\sending\models\PollPollAnswer;
use Yii;

/**
 * This is the model class for table "polls".
 *
 * @property int $hash
 * @property int $user_id
 * @property int $sending_id
 * @property int $answer_id
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
            [['hash', 'user_id', 'sending_id', 'answer_id'], 'required'],
            [['hash', 'user_id', 'sending_id', 'answer_id'], 'integer'],
            [['hash'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hash' => 'Hash',
            'user_id' => 'User ID',
            'sending_id' => 'Sending ID',
            'answer_id' => 'Answer ID',
        ];
    }

    public function getAnswers()
    {
        return $this->hasMany(PollPollAnswer::className(), ['poll_id'=>'id']);
    }
}
