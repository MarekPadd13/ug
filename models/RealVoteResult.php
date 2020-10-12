<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "real_vote_result".
 *
 * @property int $user_id
 * @property int $vote_answer
 * @property int $extension
 *
 * @property User $user
 */
class RealVoteResult extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    const ABSTAIN = 0;
    const BEHIND_JSK = 1;
    const CONTRA_JSK = 2;
    const BEHIND_MONEY = 3;
    const CONTRA_MONEY_BEHIND_JSK = 4;
    const CONTRA_MONEY_CONTRA_JSK = 5;

    public $photo;
    public $agree;

    public static function tableName()
    {
        return 'real_vote_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'vote_answer', 'photo', 'vote'], 'required'],
            ['vote', 'filter', 'filter'=> 'trim'],
            ['agree', 'required', 'requiredValue' => true, 'message' => 'без подтверждения нельзя загрузить фото'],
            [['user_id', 'vote_answer'], 'integer'],
            ['vote', 'integer', 'max'=> '100000000'],
            ['vote_answer', 'unique', 'targetAttribute' => ['user_id', 'vote_answer'], 'message' => 'Вы уже загрузили фото  и ответили на вопрос'],
//            ['photo', 'unique', 'targetAttribute' => ['extension'], 'message' => 'Вы уже загрузили фото'],
            ['photo', 'file', 'extensions' => ['jpg', 'png', 'gif', 'jpeg'], 'maxSize' => 7 * 1024 * 1024],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'vote_answer' => 'Как Вы проголосовали?',
            'vote' => 'Общее число голосов участника собрания кредиторов проще говоря сумма стоимости квартиры по ДДУ + ущерб (Указывайте только целые числа без дробей) ',
            'photo' => 'Загрузка фото бюллетени',
            'agree' => 'подтверждаю, что загрузка фото бюллетени и сообщение моего выбора я делаю добровольно 
            и в отношении меня НЕ были применены 
            признаки состава преступления, предусмотренного статьей 141 УК РФ! Я осведомлен, 
            что загрузка фото бюллетени осуществляется для предотвращения возможных фальсификации со 
            стороны организаторов и то, что фото будет удалено после подведения итогов голосования 
            (когда результаты устроят большинство дольщиков!)',
        ];
    }

    public function voteResult()
    {
        return [
            '0' => 'Воздержался',
            '1' => 'За ЖСК',
            '2' => 'Против ЖСК',
        ];
    }

    public function voteResult12()
    {
        return [
            '0' => 'Воздержался',
            '3' => 'За возврат денег',
            '4' => 'Против возврата денег и за ЖСК',
            '5' => 'Против возврата денег и против ЖСК',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */


    public function afterSave($insert, $changedAttributes)
    {

        $this->photo->saveAs(Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'vote' . DIRECTORY_SEPARATOR . 'vote_' . $this->user_id . '.' . $this->photo->extension);


        parent::afterSave($insert, $changedAttributes);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
