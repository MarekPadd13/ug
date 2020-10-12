<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_olimpiads".
 *
 * @property int $olympiads_id
 * @property int $user_id
 *
 * @property Olimpic $olympiads
 * @property User $user
 */
class UserOlimpiads extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_olimpiads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['olympiads_id', 'user_id'], 'required'],
            [['olympiads_id', 'user_id'], 'integer'],
            [['olympiads_id', 'user_id'], 'unique', 'targetAttribute' => ['olympiads_id', 'user_id']],
            [['olympiads_id'], 'exist', 'skipOnError' => true, 'targetClass' => Olimpic::className(), 'targetAttribute' => ['olympiads_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'olympiads_id' => 'Olympiads ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOlympiads()
    {
        return $this->hasOne(Olimpic::className(), ['id' => 'olympiads_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
