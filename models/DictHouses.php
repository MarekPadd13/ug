<?php

namespace app\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "dict_houses".
 *
 * @property int $id
 * @property string $name
 * @property string $deadline
 * @property int $moderation
 * @property  int $flat_count
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

    public static function moderationItem()
    {
        return [self::NEED_MODERATION => 'Нет', self::ADD_MODERATION => 'Да'];
    }

    public function getModerationName()
    {
        return self::moderationItem()[$this->moderation];
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
            [['name', 'deadline', 'moderation',], 'required'],
            [['deadline'], 'safe'],
            [['moderation','flat_count'], 'integer'],
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
            'name' => 'Номер дома',
            'deadline' => 'Deadline',
            'moderation' => 'Moderation',
            'moderationName' => 'Moderation',
            'flat_count' => 'Flat Count'
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
        return $this->hasMany(HomeImage::class, ['home_id'=>'id'])->where(['status'=> HomeImage::STATUS_PUBLISHED]);
    }

    public function getAngleGroup() {
        return $this->getImages()->select('angle_id')->groupBy('angle_id');
    }

    public function getImagesDateLast() {
        return $this->getImages()->orderBy(['date' => SORT_DESC]);
    }

    public function getLastImage() {
        return $this->getImagesDateLast()->andWhere(['date_visible'=> true ])->one();
    }

    public function getAnglesImages($angleId) {
        return $this->getImagesDateLast()->andWhere(['angle_id'=>$angleId])->all();
    }


    public function getAnglesImage($angleId) {
        return $this->getImagesDateLast()->andWhere(['angle_id'=>$angleId, 'date_visible'=> true])->one();
    }

    public function getDataEndHomeBuild() {
        return $this->hasMany(EndHomeBuild::class, ['home_id'=>'id']);
    }

    public function getMaxNumberYear($year)
    {
        return  $this->getDataEndHomeBuild()->where(['YEAR(date)' => $year])->max('number');
    }

    public function getMaxNumber()
    {
        return  $this->getDataEndHomeBuild()->max('number');
    }

    public function getLastPace()
    {
        $array = $this->getDataEndHomeBuild()->select(['number', 'date'])->orderBy(['date'=> SORT_DESC])->limit(2)->asArray()->all();
        if (count($array) > 1) {
            $result = $array[0]['number']- $array[1]['number'];
            return $result."% за период ".(date('d.m', strtotime($array[1]['date'])).'-'.date('d.m', strtotime($array[0]['date'])));
        }
        return Json::encode($array);
    }


    public function getMaxNumberYearAndMonth($year, $month)
    {
        return  $this->getDataEndHomeBuild()->where(['YEAR(date)' => $year, 'MONTH(date)' => $month])->max('number');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profiles::className(), ['house_id' => 'id']);
    }
}
