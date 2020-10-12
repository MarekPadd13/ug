<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carpooling_passengers".
 *
 * @property int $trip_id
 * @property int $user_id
 *
 * @property CarpoolingTrip $trip
 * @property User $user
 */
class CarpoolingPassengers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carpooling_passengers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['place'], 'required'],
            [['trip_id', 'user_id', 'place'], 'integer'],
            [['trip_id', 'user_id'], 'unique', 'targetAttribute' => ['trip_id', 'user_id']],
            [['trip_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarpoolingTrip::className(), 'targetAttribute' => ['trip_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'trip_id' => 'Trip ID',
            'user_id' => 'User ID',
            'place'=> 'Укажите количество бронируемых мест',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrip()
    {
        return $this->hasOne(CarpoolingTrip::className(), ['id' => 'trip_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
