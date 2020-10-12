<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "discipline_competitive_group".
 *
 * @property int $discipline_id
 * @property int $competitive_group_id
 * @property int $priority
 */
class DisciplineCompetitiveGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discipline_competitive_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['discipline_id', 'competitive_group_id', 'priority'], 'required'],
            [['discipline_id', 'competitive_group_id', 'priority'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'discipline_id' => 'Дисциплина',
            'competitive_group_id' => 'Конкурсная группа',
            'priority' => 'Приоритет',
        ];
    }

    public function getCompetitiveGroup()
    {
        return $this->hasOne(DictCompetitiveGroup::className(), ['id' => 'competitive_group_id']);
    }

    public function getDiscipline()
    {
        return $this->hasOne(DictDiscipline::className(), ['id' => 'discipline_id']);
    }
}
