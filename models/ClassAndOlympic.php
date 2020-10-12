<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "class_and_olympic".
 *
 * @property int $class_id
 * @property int $olympic_id
 *
 * @property DictClass $class
 * @property Olimpic $olimpic
 */
class ClassAndOlympic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'class_and_olympic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class_id', 'olympic_id'], 'required'],
            [['class_id', 'olympic_id'], 'integer'],
            [['class_id', 'olympic_id'], 'unique', 'targetAttribute' => ['class_id', 'olympic_id']],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictClass::className(), 'targetAttribute' => ['class_id' => 'id']],
            [['olympic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Olimpic::className(), 'targetAttribute' => ['olympic_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'class_id' => 'Class ID',
            'olympic_id' => 'Olympic ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(DictClass::className(), ['id' => 'class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOlympic()
    {
        return $this->hasOne(Olimpic::className(), ['id' => 'olympic_id']);
    }
}
