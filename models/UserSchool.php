<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_school".
 *
 * @property int $user_id
 * @property int $school_id
 * @property int $class_id
 *
 * @property DictSchoolsPreModeration $school
 * @property User $user
 * @property DictClass $class
 */
class UserSchool extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_school';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['school_id', 'class_id'], 'required'],
            [['user_id', 'school_id', 'class_id'], 'integer'],
            [['user_id', 'school_id', 'class_id'], 'unique', 'targetAttribute' => ['user_id', 'school_id', 'class_id']],
            [['school_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictSchoolsPreModeration::className(), 'targetAttribute' => ['school_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictClass::className(), 'targetAttribute' => ['class_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'school_id' => 'Название учебной организации',
            'class_id' => 'Текущий класс (курс)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchool()
    {
        return $this->hasOne(DictSchoolsPreModeration::className(), ['id' => 'school_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(DictClass::className(), ['id' => 'class_id']);
    }
}
