<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "end_home_build".
 *
 * @property int $id
 * @property int $home_id
 * @property int $number
 * @property string $date
 * @property int $created_at
 * @property int $updated_at
 *
 * @property DictHouses $home
 */
class EndHomeBuild extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'end_home_build';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['home_id', 'number', 'date'], 'required'],
            [['home_id'], 'integer'],
            [['number',], 'integer', 'max'=> 100, 'min'=> 0],
            [['date'], 'safe'],
            [['home_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictHouses::class, 'targetAttribute' => ['home_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'home_id' => 'Номер дома ',
            'number' => 'Стадия строительства(%)',
            'date' => 'Дата',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHome()
    {
        return $this->hasOne(DictHouses::class, ['id' => 'home_id']);
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }
}
