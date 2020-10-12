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
 *
 * @property User $user
 */
class UserHouseApart extends \yii\db\ActiveRecord
{
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
            [['user_id', 'house_id', 'apart_number', 'confirm'], 'required'],
            [['user_id', 'house_id', 'apart_number', 'confirm'], 'integer'],
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
            'house_id' => 'номер дома',
            'apart_number' => 'Номер квартиры',
            'confirm' => 'Подтверждение статуса дольщика',
        ];
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
