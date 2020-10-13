<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dict_houses".
 *
 * @property int $id
 * @property string $name
 * @property string $deadline
 * @property int $moderation
 *
 * @property Profiles[] $profiles
 */
class DictHouses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const NEED_MODERATION = 0;
    const ADD_MODERATION = 1;

    public function GetModerationItem()
    {
        return [self::NEED_MODERATION => 'Нет', self::ADD_MODERATION => 'Да'];
    }

    public static function tableName()
    {
        return 'dict_houses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'deadline', 'moderation'], 'required'],
            [['deadline'], 'safe'],
            [['moderation'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number_house' => 'Number House',
            'name' => 'Номер дома',
            'deadline' => 'Deadline',
            'moderation' => 'Moderation',
        ];
    }

    public static function allColumn() {
        return self::find()
            ->select('name, id')
            ->where(['moderation'=> self::ADD_MODERATION])
            ->orderBy(['name'=> SORT_ASC])
            ->indexBy('id')->column();
    }

    public function getImages() {
        return $this->hasMany(HomeImage::class, ['home_id'=>'id'])->where(['status'=> HomeImage::STATUS_PUBLISHED])->orderBy(['date' => SORT_DESC]);
    }

    public function getLastImage() {
        return $this->getImages()->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profiles::className(), ['house_id' => 'id']);
    }
}
