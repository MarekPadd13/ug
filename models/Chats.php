<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "chats".
 *
 * @property int $id
 * @property string $message
 * @property int $receiver
 * @property int $sender
 * @property int $date
 *
 * @property ChatQue[] $chatQues
 * @property User $receiver0
 * @property User $sender0
 */
class Chats extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chats';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message', 'receiver', 'sender'], 'required'],
            [['receiver', 'sender', 'looked'], 'integer'],
            [['message'], 'string', 'max' => 255],
            [['receiver'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['receiver' => 'id']],
            [['sender'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sender' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'receiver' => 'Receiver',
            'sender' => 'Sender',
            'date' => 'Date',
            'looked' => "Looked"
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatQues()
    {
        return $this->hasOne(ChatQue::className(), ['chat_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiver()
    {
        return $this->hasOne(User::className(), ['id' => 'receiver']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'sender']);
    }
}
