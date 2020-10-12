<?php

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dict_competitive_group".
 *
 * @property int $id
 * @property int $speciality_id
 * @property int $specialization_id
 * @property int $edu_level
 * @property int $education_form_id
 * @property int $financing_type_id
 * @property int $faculty_id
 * @property int $kcp
 * @property int $special_right_id
 * @property double $competition_count
 * @property int $passing_score проходной балл
 * @property string $link
 * @property int $is_new_program
 * @property int $only_pay_status
 * @property double $education_duration
 *
 * @property-read DictFaculty $faculty
 * @property-read DictSpeciality $speciality
 * @property-read DictSpecialization $specialization
 * @property-read string $eduForm
 * @property-read string $eduLevel
 * @property-read DictDiscipline[] $disciplines
 * @property-read DisciplineCompetitiveGroup[] $disciplinesCg
 */
class DictCompetitiveGroup extends \yii\db\ActiveRecord
{
    const EDUCATION_LEVEL_SPO = 0;
    const EDUCATION_LEVEL_BACHELOR = 1;
    const EDUCATION_LEVEL_MAGISTER = 2;
    const EDUCATION_LEVEL_GRADUATE_SCHOOL = 3;

    const FINANCING_TYPE_BUDGET = 1;
    const FINANCING_TYPE_CONTRACT = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_competitive_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['speciality_id', 'specialization_id', 'edu_level', 'education_form_id', 'financing_type_id', 'faculty_id', 'kcp'], 'required'],
            [['id', 'speciality_id', 'specialization_id', 'edu_level', 'education_form_id', 'financing_type_id', 'faculty_id', 'kcp', 'special_right_id', 'passing_score', 'is_new_program', 'only_pay_status'], 'integer'],
            [['competition_count'], 'number'],
            [['education_duration'], 'safe'],
            [['link'], 'string', 'max' => 255],
            [['speciality_id', 'specialization_id', 'education_form_id', 'financing_type_id', 'faculty_id', 'special_right_id'],
                'unique', 'targetAttribute' => ['speciality_id', 'specialization_id', 'education_form_id', 'financing_type_id', 'faculty_id', 'special_right_id'],
                'message' => 'Такое сочетание уже есть']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'speciality_id' => 'Направление подготовки',
            'specialization_id' => 'Образовательная программа',
            'edu_level' => 'Уровень образования',
            'education_form_id' => 'Форма обучения',
            'financing_type_id' => 'Вид финансирования',
            'faculty_id' => 'Факультет',
            'kcp' => 'КЦП',
            'special_right_id' => 'Квота /целевое',
            'competition_count' => 'Конкурс',
            'passing_score' => 'Проходной балл',
            'link' => 'Ссылка на ООП',
            'is_new_program' => 'Новая программа',
            'only_pay_status' => 'Только на платной основе',
            'education_duration' => 'Срок обучения',
        ];
    }

    public function getEduForms()
    {
        return ['1' => 'Очная', '2' => 'Очно-заочная', '3' => 'Заочная'];
    }

    public function getFinancingTypes()
    {
        return [self::FINANCING_TYPE_BUDGET => 'Бюджет', self::FINANCING_TYPE_CONTRACT => 'Договор'];
    }

    public function getEduLevels()
    {
        return [self::EDUCATION_LEVEL_SPO => 'СПО', self::EDUCATION_LEVEL_BACHELOR => 'Бакалавриат',
            self::EDUCATION_LEVEL_MAGISTER => 'Магистратура', self::EDUCATION_LEVEL_GRADUATE_SCHOOL => 'Аспирантура'];
    }

    public function getSpecialRight()
    {
        return ['0' => 'Обычная', '1' => 'Квота', '2' => 'Целевое'];
    }

    public function getEduForm()
    {
        return $this->getEduForms()[$this->education_form_id];
    }

    public function getFaculty()
    {
        return $this->hasOne(DictFaculty::className(), ['id' => 'faculty_id']);
    }

    public function getSpeciality()
    {
        return $this->hasOne(DictSpeciality::className(), ['id' => 'speciality_id']);
    }

    public function getSpecialization()
    {
        return $this->hasOne(DictSpecialization::className(), ['id' => 'specialization_id']);
    }

    public function getDisciplines()
    {
        return $this->hasMany(DictDiscipline::className(), ['id' => 'discipline_id'])
            ->viaTable(DisciplineCompetitiveGroup::tableName(), ['competitive_group_id' => 'id']);
    }

    public function getDisciplinesCg()
    {
        return $this->hasMany(DisciplineCompetitiveGroup::className(), ['competitive_group_id' => 'id'])
            ->orderBy([DisciplineCompetitiveGroup::tableName() . '.priority' => SORT_ASC]);

    }

    public function getPriority()
    {
        return ['1' => '1', '2' => '2', '3' => '3'];
    }

    public static function fullNameCg()
    {
        $specialityId = DictSpeciality::find()->select('name')->indexBy('id')->column();
        $specializationId = DictSpecialization::find()->select('name')->indexBy('id')->column();
        $facultyId = DictFaculty::find()->select('full_name')->indexBy('id')->column();
        $form_edu = ['1' => 'Очная', '2' => 'Очно-заочная', '3' => 'Заочная'];
        $edu_level = ['1' => 'БАК', '2' => 'МАГ', '3' => 'АСП'];

        $cg = ArrayHelper::map(DictCompetitiveGroup::find()->all(), 'id', function ($model) use ($specialityId, $specializationId, $form_edu, $edu_level, $facultyId) {
            return
                $edu_level[$model->edu_level]
                . " / " . $facultyId[$model->faculty_id]
                . " / " . $specialityId[$model->speciality_id]
                . " / " . $specializationId[$model->specialization_id]
                . " / " . $form_edu[$model->education_form_id];
        });

        return $cg;
    }

    public function getFullName()
    {
        $specialityId = DictSpeciality::find()->select('name')->indexBy('id')->column();
        $specializationId = DictSpecialization::find()->select('name')->indexBy('id')->column();
        $facultyId = DictFaculty::find()->select('full_name')->indexBy('id')->column();
        $form_edu = ['1' => 'Очная', '2' => 'Очно-заочная', '3' => 'Заочная'];
        $edu_level = ['1' => 'БАК', '2' => 'МАГ', '3' => 'АСП'];

        return $edu_level[$this->edu_level]
            . " / " . $facultyId[$this->faculty_id]
            . " / " . $specialityId[$this->speciality_id]
            . " / " . $specializationId[$this->specialization_id]
            . " / " . $form_edu[$this->education_form_id];
    }

}
