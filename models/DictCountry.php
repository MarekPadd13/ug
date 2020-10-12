<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dict_country".
 *
 * @property int $id
 * @property string $name Название страны
 * @property int $cis СНГ
 * @property int $far_abroad Дальнее зарубежье
 *
 * @property DictCity $dictCity
 */
class DictCountry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'cis', 'far_abroad'], 'required'],
            [['cis', 'far_abroad'], 'integer'],
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
            'cis' => 'Cis',
            'far_abroad' => 'Far Abroad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictCity()
    {
        return $this->hasOne(DictCity::className(), ['country' => 'id']);
    }
}
