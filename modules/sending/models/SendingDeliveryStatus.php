<?php

namespace app\modules\sending\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "sending_delivery_status".
 *
 * @property int $sending_id
 * @property int $user_id
 * @property int $status_id 0 - ожидание ответа, 1 - прочитано
 *
 * @property Sending $sending
 * @property User $user
 */
class SendingDeliveryStatus extends \yii\db\ActiveRecord
{

    const STATUS_READY_TO_BE_SEND = 0;
    const STATUS_SEND = 1;
    const STATUS_READ = 2;
    const STATUS_NO_EMAIL = 3;
    const STATUS_HAS_POLL = 4;


    const ALL_EMAIL_STATUS = [
        self::STATUS_SEND => 'Отправлено',
        self::STATUS_READ => 'Прочитано',
        self::STATUS_NO_EMAIL => 'Не указан адрен электронной почты',
        self::STATUS_HAS_POLL => 'Пользователь прошел опрос'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sending_delivery_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sending_id', 'user_id', 'status_id'], 'required'],
            [['sending_id', 'user_id', 'status_id', 'poll_answer_id'], 'integer'],
            [['delivery_date_time', 'date_time_poll_answer'], 'safe'],
            ['poll_text', 'string'],
            ['hash', 'string', 'max' => 255],
            [['sending_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sending::className(), 'targetAttribute' => ['sending_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sending_id' => 'Название рассылки',
            'user_id' => 'Получатель письма',
            'status_id' => 'Статус доставки',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSending()
    {
        return $this->hasOne(Sending::className(), ['id' => 'sending_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getTimePlus24Hours($hash)
    {
        $vote = SendingDeliveryStatus::find()->andWhere(['hash' => $hash])->one();
        $futureDate = date('Y-m-d H:i:s', strtotime($vote->date_time_poll_answer ?? 0) + 3600 * 24);

        return $futureDate;


    }

    public static function getCheckAnsweredPoll($hash)
    {
        $model = SendingDeliveryStatus::find()->andWhere(['hash' => $hash])->one();

        return $model->poll_answer_id ?? null;
    }

    public static function countVote($pollId, $pollAnswerId)
    {


        return SendingDeliveryStatus::find()
            ->andWhere(['in','sending_id', Sending::find()
                ->select('id')
                ->andWhere(['poll_id'=> $pollId])
                ->column()])
            ->andWhere(['poll_answer_id' => $pollAnswerId])
            ->count();
    }
}
