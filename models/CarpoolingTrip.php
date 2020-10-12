<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carpooling_trip".
 *
 * @property int $id
 * @property int $user_id
 * @property int $places
 * @property string $date
 * @property string $note
 *
 * @property CarpoolingMetro[] $carpoolingMetros
 * @property CarpoolingPassengers[] $carpoolingPassengers
 * @property User[] $users
 * @property User $user
 */
class CarpoolingTrip extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carpooling_trip';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'places', 'date', 'type_id'], 'required'],
            [['user_id', 'places'], 'integer'],
            ['date', 'unique', 'targetAttribute' => ['user_id', 'date', 'type_id'], 'message' => 'Предполагается, 
            что один дольщик может поехать в/из ЖК только один раз за день.'],
            [['date'], 'safe'],
            [['note'], 'string', 'max' => 255],
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
            'user_id' => 'User ID',
            'type_id' => 'Тип поездки',
            'places' => 'Количество свободный мест в машине',
            'date' => 'Дата поездки',
            'note' => 'Примечание',
        ];
    }

    public static function typeTrip()
    {
        return [
            '1' => 'из Москвы в ЖК "Видный город"',
            '2' => 'из ЖК "Видный город" в Москву',
            '3'=> 'из Москвы в МУП «Одинцовский районный дом культуры и творчества»',
            '4'=> 'из МУП «Одинцовский районный дом культуры и творчества» в Москву',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarpoolingMetros()
    {
        return $this->hasMany(CarpoolingMetro::className(), ['trip_id' => 'id']);
    }

    public function vacantPlaces()
    {
        $passengers = array_sum(CarpoolingPassengers::find()->select('place')->andWhere(['trip_id' => $this->id])->column());


        return $this->places - $passengers;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarpoolingPassengers()
    {
        return $this->hasMany(CarpoolingPassengers::className(), ['trip_id' => 'id']);
    }

    public static function correctPlaces($places)
    {
        $mesto = 1;
        $mesta = [2, 3, 4];

        if ($places == $mesto) {
            return $places . '<br/> место';
        } else if (in_array($places, $mesta)) {
            return $places . '<br/> места';

        } else {
            return $places . '<br/> мест';
        }

    }

    public function dropDownVacant()
    {
        $result = [];

        for ($i=1; $i <= $this->vacantPlaces(); $i++)
        {
            $result[$i] = $i;
        }
        return $result;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('carpooling_passengers', ['trip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
