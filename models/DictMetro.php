<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dict_metro".
 *
 * @property int $id
 * @property string $name
 *
 * @property CarpoolingMetro[] $carpoolingMetros
 */
class DictMetro extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_metro';
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
            'name' => 'Станция метро',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarpoolingMetros()
    {
        return $this->hasMany(CarpoolingMetro::className(), ['metro_id' => 'id']);
    }
}
