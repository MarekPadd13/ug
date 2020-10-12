<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dict_region".
 *
 * @property int $id
 * @property string $name название региона
 *
 * @property DictCity $dictCity
 */
class DictRegion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictCity()
    {
        return $this->hasOne(DictCity::className(), ['region' => 'id']);
    }
}
