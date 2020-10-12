<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_answer_user".
 *
 * @property int $id
 * @property int $ref_answer_id
 * @property int $user_id
 * @property int $ball
 *
 * @property RefAnswer $refAnswer
 * @property User $user
 */
class RefAnswerUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_answer_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ref_answer_id', 'user_id', 'voting_result', 'ball'], 'required'],
            [['id', 'ref_answer_id', 'user_id', 'ball', 'voting_result', 'komment'], 'integer'],
            ['komment_text', 'string', 'max'=>56],
            [['ref_answer_id', 'user_id'], 'unique', 'message'=>'Вы уже проголосовали!'],
            [['ref_answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefAnswer::className(), 'targetAttribute' => ['ref_answer_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref_answer_id' => 'Ref Answer ID',
            'user_id' => 'User ID',
            'ball' => 'Насколько Вам понравилось данное решение? Укажите оценку от 1 до 10',
            'komment'=> 'Укажите причину Вашего неодобрения идеи:',
            'komment_text' => 'Укажите свой вариант',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefAnswer()
    {
        return $this->hasOne(RefAnswer::className(), ['id' => 'ref_answer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
