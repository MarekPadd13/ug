<?php

namespace app\models;

/**
 * This is the model class for table "user_dod".
 *
 * @property int $user_id
 * @property int $dod_id
 *
 * @property Dod $dod
 * @property User $user
 */
class UserDod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_dod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'dod_id'], 'required'],
            [['user_id', 'dod_id'], 'integer'],
            [['dod_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dod::className(), 'targetAttribute' => ['dod_id' => 'id']],
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
            'dod_id' => 'Dod ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDod()
    {
        return $this->hasOne(Dod::className(), ['id' => 'dod_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
