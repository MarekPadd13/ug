<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "options_for_activism".
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property int $moderation
 *
 * @property Profiles[] $profiles
 */
class OptionsForActivism extends \yii\db\ActiveRecord
{
    const NEED_MODERATION = 0;
    const ADD_MODERATION = 1;

    public function GetModerationItem()
    {
        return [self::NEED_MODERATION => 'Нет', self::ADD_MODERATION => 'Да'];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'options_for_activism';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'user_id', 'moderation'], 'required'],
            [['user_id', 'moderation'], 'integer'],
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
            'name' => 'Name',
            'user_id' => 'User ID',
            'moderation' => 'Moderation',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profiles::className(), ['activizm_id' => 'id']);
    }
}
