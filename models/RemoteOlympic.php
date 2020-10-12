<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "remote_olympic".
 *
 * @property int $id
 * @property string $name
 * @property int $dict_faculty_id
 * @property int $form_of_conduct
 * @property string $date_start_of_registration
 * @property string $date_finish_of_registration
 * @property int $supervisor_id
 *
 * @property PrivateOlympic[] $privateOlympics
 * @property DictSupervisor $supervisor
 * @property Tests[] $tests
 */
class RemoteOlympic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'remote_olympic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'dict_faculty_id', 'form_of_conduct', 'date_start_of_registration', 'date_finish_of_registration', 'supervisor_id'], 'required'],
            [['dict_faculty_id', 'form_of_conduct', 'supervisor_id'], 'integer'],
            [['date_start_of_registration', 'date_finish_of_registration'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['supervisor_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictSupervisor::className(), 'targetAttribute' => ['supervisor_id' => 'id']],
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
            'dict_faculty_id' => 'Dict Faculty ID',
            'form_of_conduct' => 'Form Of Conduct',
            'date_start_of_registration' => 'Date Start Of Registration',
            'date_finish_of_registration' => 'Date Finish Of Registration',
            'supervisor_id' => 'Supervisor ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrivateOlympics()
    {
        return $this->hasMany(PrivateOlympic::className(), ['remote_olympic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupervisor()
    {
        return $this->hasOne(DictSupervisor::className(), ['id' => 'supervisor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Tests::className(), ['olympic_id' => 'id']);
    }
}
