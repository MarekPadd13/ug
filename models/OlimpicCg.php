<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "olimpic_cg".
 *
 * @property int $olimpic_id
 * @property int $competitive_group_id
 *
 * @property DictCompetitiveGroup $competitiveGroup
 * @property Olimpic $olimpic
 */
class OlimpicCg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'olimpic_cg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['olimpic_id', 'competitive_group_id'], 'required'],
            [['olimpic_id', 'competitive_group_id'], 'integer'],
            [['olimpic_id', 'competitive_group_id'], 'unique', 'targetAttribute' => ['olimpic_id', 'competitive_group_id']],
            [['competitive_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictCompetitiveGroup::className(), 'targetAttribute' => ['competitive_group_id' => 'id']],
            [['olimpic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Olimpic::className(), 'targetAttribute' => ['olimpic_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'olimpic_id' => 'Olimpic ID',
            'competitive_group_id' => 'Competitive Group ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitiveGroup()
    {
        return $this->hasOne(DictCompetitiveGroup::className(), ['id' => 'competitive_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOlimpic()
    {
        return $this->hasOne(Olimpic::className(), ['id' => 'olimpic_id']);
    }
}
