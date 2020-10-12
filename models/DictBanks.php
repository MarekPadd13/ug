<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dict_banks".
 *
 * @property int $id
 * @property string $name
 * @property int $moderation
 *
 * @property Profiles[] $profiles
 */
class DictBanks extends \yii\db\ActiveRecord
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
        return 'dict_banks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'moderation'], 'required'],
            [['moderation'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['name', 'unique', 'targetClass' => DictBanks::className(), 'message' => 'Такой банк уже есть в списке'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Введите название банка',
            'moderation' => 'Moderation',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profiles::className(), ['bank_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes){
        if($insert){
    Yii::$app->session->setFlash('success', 'Название банка добавлено в список.');
        }else{
        Yii::$app->session->setFlash('success', 'Название банка обновлено в списке.');   
        }
        
        parent::afterSave($insert, $changedAttributes);
    }

}
