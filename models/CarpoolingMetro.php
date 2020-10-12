<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carpooling_metro".
 *
 * @property int $carpooling_trip_id
 * @property int $metro_id
 * @property string $time
 *
 * @property CarpoolingTrip $carpoolingTrip
 * @property DictMetro $metro
 */
class CarpoolingMetro extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carpooling_metro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trip_id', 'metro_id', 'time'], 'required'],
            [['trip_id', 'metro_id'], 'integer'],
            [['time'], 'safe'],
            [['metro_id'], 'unique', 'targetAttribute' => ['trip_id', 'metro_id'], 'message'=> 'Вы уже добавили эту станцию метро!'],
            [['trip_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarpoolingTrip::className(), 'targetAttribute' => ['trip_id' => 'id']],
            [['metro_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictMetro::className(), 'targetAttribute' => ['metro_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'metro_id' => 'Станция метро',
            'time' => 'Примерное время встречи',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarpoolingTrip()
    {
        return $this->hasOne(CarpoolingTrip::className(), ['id' => 'trip_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMetro()
    {
        return $this->hasOne(DictMetro::className(), ['id' => 'metro_id']);
    }
}
