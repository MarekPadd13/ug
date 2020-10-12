<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "private_olympic".
 *
 * @property int $id
 * @property string $name
 * @property string $date
 * @property string $address
 * @property int $remote_olympic_id
 *
 * @property RemoteOlympic $remoteOlympic
 */
class PrivateOlympic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'private_olympic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'date', 'address'], 'required'],
            [['remote_olympic_id'], 'integer'],
            [['name', 'date', 'address'], 'string', 'max' => 255],
            [['remote_olympic_id'], 'exist', 'skipOnError' => true, 'targetClass' => RemoteOlympic::className(), 'targetAttribute' => ['remote_olympic_id' => 'id']],
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
            'date' => 'Date',
            'address' => 'Address',
            'remote_olympic_id' => 'Remote Olympic ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRemoteOlympic()
    {
        return $this->hasOne(RemoteOlympic::className(), ['id' => 'remote_olympic_id']);
    }
}
