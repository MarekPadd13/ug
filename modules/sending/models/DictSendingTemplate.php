<?php

namespace app\modules\sending\models;

use Yii;

/**
 * This is the model class for table "dict_sending_template".
 *
 * @property int $id
 * @property string $name
 * @property string $html
 * @property string $text
 * @property string $hash
 * @property int $check_status
 *
 * @property Sending[] $sendings
 * @property Sending[] $sendings0
 */
class DictSendingTemplate extends \yii\db\ActiveRecord
{

    const CHECK = 1;
    const NO_CHECK = 0;
    const CHECK_STATUS_TYPE = [
        self::NO_CHECK => 'не проверен',
        self::CHECK => 'проверен',

    ];

    const TYPE_OF_TEMPLATE = [
        ''=>'',
        Sending::USER_SEND_FOR_PERSONAL_TOUR_MEMBER => 'Приглашение на очный тур',
        Sending::USER_SEND_FOR_WINNER => 'Рассылка сертификатов победителям',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_sending_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'html', 'text'], 'required'],
            [['html', 'text'], 'string'],
            [['check_status', 'base_type'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название шаблона',
            'html' => 'Html-шаблон рассылки',
            'text' => 'Аналогичный текст рассылки',
            'check_status' => 'Проверен/Не проверен',
            'base_type' => 'Указать базовый тип шаблона',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSendings()
    {
        return $this->hasMany(Sending::className(), ['sending_category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSendings0()
    {
        return $this->hasMany(Sending::className(), ['template_id' => 'id']);
    }

    public static function getAllTemplateName()
    {
        return DictSendingTemplate::find()->select('name')->indexBy('id')->column();
    }

}
