<?php

namespace app\modules\sending\models;

use Yii;

/**
 * This is the model class for table "dict_sending_user_category".
 *
 * @property int $id
 * @property string $name
 */
class DictSendingUserCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_sending_user_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'unique', 'message' => 'Название категории должно быть уникальным'],
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
            'name' => 'Название категории',
        ];
    }

    public static function getAllCategoriesName()
    {
        return DictSendingUserCategory::find()->select('name')->indexBy('id')->column();
    }
}
