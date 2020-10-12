<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_master_class".
 *
 * @property int $user_id
 * @property int $master_class_id
 *
 * @property MasterClass $masterClass
 * @property User $user
 */
class UserMasterClass extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_master_class';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'master_class_id'], 'required'],
            [['user_id', 'master_class_id'], 'integer'],
            [['master_class_id'], 'exist', 'skipOnError' => true, 'targetClass' => MasterClass::className(), 'targetAttribute' => ['master_class_id' => 'id']],
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
            'master_class_id' => 'Мастер-классы',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMasterClass()
    {
        return $this->hasOne(MasterClass::className(), ['id' => 'master_class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
