<?php

namespace app\models;

use app\modules\sending\models\DictSendingUserCategory;
use app\modules\sending\models\SendingUserCategory;
use Yii;

/**
 * This is the model class for table "user_house_apart".
 *
 * @property int $user_id
 * @property int $house_id
 * @property int $apart_number
 * @property int $confirm
 * @property int $type
 * @property int $floor
 * @property int $entrance
 * @property float $sq
 *
 * @property User $user
 */
class UserHouseApart extends \yii\db\ActiveRecord
{

    const TYPE_RESIDENTIAL =  1;
    const TYPE_NO_RESIDENTIAL =  2;

    const SCENARIO_CONFIRM = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_house_apart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'house_id',  'confirm', 'apart_number',], 'required'],
            [['floor'], 'required', 'when'=> function($model) {
                         return $model->type == self::TYPE_RESIDENTIAL;
            }],
            [['user_id', 'house_id', 'apart_number', 'confirm', 'entrance', 'floor'], 'integer'],
            [['sq'], 'number'],
            [['sq', 'type', 'entrance'], 'required', 'except' => self::SCENARIO_CONFIRM],
            [['user_id', 'house_id', 'apart_number'], 'unique', 'targetAttribute' => ['user_id', 'house_id', 'apart_number']],
            [['apart_number'], 'unique', 'targetAttribute' => ['user_id', 'house_id', 'apart_number'], 'message' => 'Вы уже добавили эту квартиру'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'house_id' => 'Номер дома',
            'apart_number' => 'Номер помещения',
            'confirm' => 'Подтверждение статуса дольщика',
            'floor' => "Этаж",
            'entrance' => "Подъезд/секция",
            'sq' => " Доля владения в кв.м",
            'type' => "Тип помещения"
        ];
    }

    public static function types() {
        return [
            self::TYPE_RESIDENTIAL => "Жилое",
            self::TYPE_NO_RESIDENTIAL => "Нежилое",
        ];
    }

    public function getTypeName() {
        return self::types()[$this->type];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getProfile()
    {
        return $this->hasOne(Profiles::className(), ['user_id' => 'user_id']);
    }

    public static function NoConfirm()
    {
            return !UserHouseApart::find()->andWhere(['user_id'=> Yii::$app->user->id])->andWhere(['confirm'=> true])->exists();
    }


    public function getUserCategory()
    {
        return $this->hasOne(DictSendingUserCategory::class, ['house_id'=> 'house_id']);
    }


}
