<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "olimpiads_type_templates".
 *
 * @property int $number_of_tours количество туров
 * @property int $form_of_passage Форма проведения
 * @property int $edu_level_olimp Уровень олимпиады
 * @property int $template_id шаблон
 *
 * @property Templates $template
 */
class OlimpiadsTypeTemplates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'olimpiads_type_templates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number_of_tours', 'form_of_passage', 'edu_level_olimp', 'template_id'], 'required'],
            [['number_of_tours', 'form_of_passage', 'edu_level_olimp', 'template_id'], 'integer'],
            [['number_of_tours', 'form_of_passage', 'edu_level_olimp', 'template_id'], 'unique', 'targetAttribute' => ['number_of_tours', 'form_of_passage', 'edu_level_olimp', 'template_id']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Templates::className(), 'targetAttribute' => ['template_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'number_of_tours' => 'Количество туров',
            'form_of_passage' => 'Форма проведения',
            'edu_level_olimp' => 'Уровень олимпиады',
            'template_id' => 'Шаблон',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Templates::className(), ['id' => 'template_id']);
    }
}
