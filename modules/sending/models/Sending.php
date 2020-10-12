<?php

namespace app\modules\sending\models;

use app\models\Dod;
use app\models\Profiles;
use Yii;
use app\models\Olimpic;
use app\models\Diploma;
use app\models\PersonalPresenceAttempt;
use app\components\DateTimeToChpu;
use app\models\Invitation;
use yii\helpers\Html;
use app\models\UserHouseApart;
use app\modules\sending\models\SendingDeliveryStatus;

/**
 * This is the model class for table "sending".
 *
 * @property int $id
 * @property string $name
 * @property int $sending_category_id
 * @property int $template_id
 * @property int $status_id 0- не начиналась, 1- одобрена, 2- завершилась
 *
 * @property DictSendingTemplate $sendingCategory
 * @property DictSendingTemplate $template
 * @property SendingDeliveryStatus[] $sendingDeliveryStatuses
 */
class Sending extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const WEITING_MODERATION = 0;
    const CONFIRM = 1;
    const FINISH_SENDING = 2;

    const USER_SEND_FOR_PERSONAL_TOUR_MEMBER = 1;
    const USER_SEND_FOR_WINNER = 2;

    const TYPE_TEXT = 1;
    const TYPE_HTML = 2;

    const TYPE_SENDING = [
        self::WEITING_MODERATION => 'Ожидает проверки',
        self::CONFIRM => 'Одобрена',
        self::FINISH_SENDING => 'Завершена',

    ];

    const VIA_EMAIL_WA = 1;
    const VIA_WA_ONLY = 2;
    const KIND_OF_SENDING = [
        self::VIA_EMAIL_WA => 'Авторассылка на почту и ручная в WA',
        self::VIA_WA_ONLY => 'Ручная рассылка в WA',
    ];

    public static function tableName()
    {
        return 'sending';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'sending_category_id', 'template_id', 'status_id', 'kind_sending_id'], 'required'],
            [['sending_category_id', 'template_id', 'status_id', 'user_id', 'type_id', 'value', 'poll_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['deadline', 'safe'],
            ['kind_sending_id', 'integer'],
            [['sending_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictSendingUserCategory::className(), 'targetAttribute' => ['sending_category_id' => 'id']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictSendingTemplate::className(), 'targetAttribute' => ['template_id' => 'id']],
            ['name', 'unique', 'targetAttribute' => ['name', 'sending_category_id', 'template_id'], 'message' => 'Такая рассылка уже существует!'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Тема письма',
            'sending_category_id' => 'Категория пользователей',
            'template_id' => 'Шаблон письма',
            'status_id' => 'Статус рассылки',
            'deadline' => 'Директивный срок (дедлайн)',
            'kind_sending_id' => 'Укажите тип рассылки',
            'poll_id' => 'Присоединить опрос',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSendingCategory()
    {
        return $this->hasOne(DictSendingTemplate::className(), ['id' => 'sending_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(DictSendingTemplate::className(), ['id' => 'template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSendingDeliveryStatuses()
    {
        return $this->hasMany(SendingDeliveryStatus::className(), ['sending_id' => 'id']);
    }

    public static function getLetter($sendingId, $userId, $type = null, $hash)
    {

        $model = Sending::find()->andWhere(['id' => $sendingId])->one();

        $profile = Profiles::find()->andWhere(['user_id' => $userId])->one();

        $vote = SendingDeliveryStatus::find()->andWhere(['hash' => $hash])->one();

        $allAnswer = DictPollAnswers::getAllItems();

        $hostName = 'https://jk-vidniy-gorod.ru';

        if ($model->poll_id) {
            $poll = '<p>' . $model->poll->content . '</p>';
            $futureDate = SendingDeliveryStatus::getTimePlus24Hours($hash);
            if (SendingDeliveryStatus::getCheckAnsweredPoll($hash) === null) {
                $pollAnswer = $model->poll->pollAnswers;
                foreach ($pollAnswer as $answer) {
                    $poll .= '<p>' . Html::a($answer->name, ['save-poll-result', 'answerId' => $answer->id, 'hash' => $hash],
                            ['class' => 'btn btn-info btn-block']) . '</p>';
                }
            } else {
                $poll .= '<p>';
                $poll .= isset($vote->poll_answer_id) ? 'Вы выбрали: ' . $allAnswer[$vote->poll_answer_id] : '';
                $poll .= '</p>';
            }

            if (date('Y-m-d H:i:s') <= $futureDate && SendingDeliveryStatus::getCheckAnsweredPoll($hash)) {

                $poll .= '<p>';
                $poll .= 'Спасибо, за участие! Вы можете отменить свой голос. '
                    . DateTimeToChpu::getDateChpu($futureDate) .
                    ' в '
                    . DateTimeToChpu::getTimeChpu($futureDate)
                    . ' возможность отменить и поменять свой голос заблокируется!';
                $poll .= '</p>';
                $poll .= Html::a('Отменить', ['delete-poll-result', 'hash' => $hash],
                    ['class' => 'btn btn-warning btn-block']);

            }
        }

        $replaceLabels = [
            $profile->patronymic ? $profile->first_name . ' ' . $profile->patronymic
                : $profile->first_name,
            $model->poll_id ? $poll : 'нет опроса', // Опрос
            $hostName . '/msg-view/' . $hash,  // ссылка на страницу опроса

        ];

        $labels = [
            '{имя отчество получателя}',
            '{опрос}',
            '{ссылка на страницу}',
        ];

        //@TODO дописать для остальных мероприятий


        if ($type == self::TYPE_TEXT) {
            $emailBodyHtml = str_replace($labels, $replaceLabels, $model->template->text);

        } else {
            $emailBodyHtml = str_replace($labels, $replaceLabels, $model->template->html);

        }

        return $emailBodyHtml;
    }

    public static function getKindOfSending()
    {
        return [
            1 => 'Авторассылка на почту и ручная в WA',
            2 => 'Ручная рассылка в WA',
        ];
    }

    public function getPoll()
    {
        return $this->hasOne(Polls::className(), ['id' => 'poll_id']);
    }


    public static function PersentUserInCategory($sendingId)
    {
        $sending = Sending::find()->andWhere(['id'=>$sendingId])->one();
        $houseId = $sending->house_id ?? 0;
        return UserHouseApart::find()
            ->andWhere(['house_id'=>$houseId])
            ->andWhere(['not in', 'user_id', SendingDeliveryStatus::find()
                ->select('user_id')
                ->andWhere(['sending_id'=>$sendingId])
                ->column()])->exists();
    }

}
