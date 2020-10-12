<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dict_faculty".
 *
 * @property int $id
 * @property string $name
 *
 * @property DictSupervisor[] $dictSupervisors
 */
class DictFaculty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_faculty';
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
    public function getDictSupervisors()
    {
        return $this->hasMany(DictSupervisor::className(), ['dict_faculty_id' => 'id']);
    }
}
