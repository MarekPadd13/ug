<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tests".
 *
 * @property int $id
 * @property string $name название
 * @property string $date_of_start дата начала
 * @property string $date_of_finish дата конца
 * @property int $number_of_attempts количество попыток
 * @property string $timer таймер
 * @property int $olympic_id id олимпиады
 * @property int $class какие классы могут принимать участие?
 *
 * @property RemoteOlympic $olympic
 */
class Tests extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tests';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'date_of_start', 'date_of_finish', 'number_of_attempts', 'timer', 'olympic_id', 'class'], 'required'],
            [['date_of_start', 'date_of_finish', 'timer'], 'safe'],
            [['number_of_attempts', 'olympic_id', 'class'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['olympic_id'], 'exist', 'skipOnError' => true, 'targetClass' => RemoteOlympic::className(), 'targetAttribute' => ['olympic_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'date_of_start' => 'Date Of Start',
            'date_of_finish' => 'Date Of Finish',
            'number_of_attempts' => 'Number Of Attempts',
            'timer' => 'Timer',
            'olympic_id' => 'Olympic ID',
            'class' => 'Class',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOlympic()
    {
        return $this->hasOne(RemoteOlympic::className(), ['id' => 'olympic_id']);
    }
}
