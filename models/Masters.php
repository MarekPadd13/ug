<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masters".
 *
 * @property int $id
 * @property string $name
 * @property string $status
 * @property int $faculty_id
 *
 * @property MasterClass[] $masterClasses
 * @property DictFaculty $faculty
 */
class Masters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masters';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status', 'faculty_id'], 'required'],
            [['name', 'status'], 'string'],
            [['faculty_id'], 'integer'],
            [['faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictFaculty::className(), 'targetAttribute' => ['faculty_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'ФИО ведущего',
            'status' => 'Должность, регалии',
            'faculty_id' => 'Институт/факультет',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMasterClasses()
    {
        return $this->hasMany(MasterClass::className(), ['master_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaculty()
    {
        return $this->hasOne(DictFaculty::className(), ['id' => 'faculty_id']);
    }
}
