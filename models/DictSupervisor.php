<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dict_supervisor".
 *
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string $patronymic
 * @property string $email
 * @property string $phone
 * @property string $post
 * @property int $dict_faculty_id
 *
 * @property DictFaculty $dictFaculty
 * @property RemoteOlympic[] $remoteOlympics
 */
class DictSupervisor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_supervisor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_name', 'first_name', 'patronymic', 'email', 'phone', 'post', 'dict_faculty_id'], 'required'],
            [['dict_faculty_id'], 'integer'],
            [['last_name', 'first_name', 'patronymic', 'email', 'post'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 17],
            [['dict_faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictFaculty::className(), 'targetAttribute' => ['dict_faculty_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'patronymic' => 'Patronymic',
            'email' => 'Email',
            'phone' => 'Phone',
            'post' => 'Post',
            'dict_faculty_id' => 'Dict Faculty ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictFaculty()
    {
        return $this->hasOne(DictFaculty::className(), ['id' => 'dict_faculty_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRemoteOlympics()
    {
        return $this->hasMany(RemoteOlympic::className(), ['supervisor_id' => 'id']);
    }
}
