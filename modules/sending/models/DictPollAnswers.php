<?php

namespace app\modules\sending\models;

use Yii;

/**
 * This is the model class for table "dict_poll_answers".
 *
 * @property int $id
 * @property string $name
 *
 * @property PollPollAnswer[] $pollPollAnswers
 * @property Polls[] $polls
 */
class DictPollAnswers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_poll_answers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 25],
            ['text_addition', 'integer'],
            ['name', 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'text_addition' => 'Дополнительное текстовое поле',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPollPollAnswers()
    {
        return $this->hasMany(PollPollAnswer::className(), ['poll_answer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public static function getAllItems()
    {
        return DictPollAnswers::find()->select('name')->indexBy('id')->column();
    }
}
