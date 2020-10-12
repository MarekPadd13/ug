<?php

namespace app\models;

use himiklab\yii2\common\MultipleListBehavior;

/**
 * This is the model class for table "olimpic".
 *
 * @property int $id
 * @property string $name Полное название мероприятия
 * @property int $chairman_id Председатель
 * @property int $number_of_tours Количество туров
 * @property int $form_of_passage Форма проведения
 * @property int $edu_level_olymp Уровень проведения олимпиад
 * @property string $date_time_start_reg дата и время начала регистрации
 * @property string $date_time_finish_reg дата и время окончания регистрации
 * @property string $time_of_distants_tour Продолжительность выполнения заданий заочного (дистанционного) тура
 * @property string $date_time_start_tour Дата и время проведения очного тура
 * @property string $address Адрес проведения очного тура
 * @property string $time_of_tour Продолжительность очного тура в минутах
 * @property string $requiment_to_work_of_distance_tour Требование к выполнению работ заочного (дистанционного) тура (только если он был заявлен)
 * @property string $requiment_to_work Требование к выполнению работ очного тура
 * @property string $criteria_for_evaluating_dt Критерии оценивания работ заочного (дистанционного) тура
 * @property string $criteria_for_evaluating Требование к выполнению работ очного тура
 * @property int $showing_works_and_appeal Показ работ и апелляция (Предусмотрены / не предусмотрены)
 *
 * @property ClassAndOlympic[] $classAndOlympics
 * @property DictClass[] $classes
 * @property DictChairmans $chairman
 * @property OlimpicCg[] $olimpicCgs
 * @property DictCompetitiveGroup[] $competitiveGroups
 */
class Olimpic extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => MultipleListBehavior::class,
                'relations' => [
                    'competitiveGroups' => [
                        'type' => MultipleListBehavior::RELATION_TYPE_JUNCTION,
                        'attribute' => OlimpicCg::class
                    ],
                    'classes' => [
                        'type' => MultipleListBehavior::RELATION_TYPE_JUNCTION,
                        'attribute' => ClassAndOlympic::class
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'olimpic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'chairman_id', 'number_of_tours', 'edu_level_olymp', 'date_time_start_reg', 'date_time_finish_reg', 'competitiveGroupsList', 'classesList', 'genitive_name', 'faculty_id'], 'required', 'when' => function ($model) {
                return $model->prefilling == 0;
            }, 'whenClient' => 'function(attribute, value){
                    return $("#olimpic-prefilling").val ==0}'],


            ['time_of_distants_tour_type', 'required', 'when' => function ($model) {
                return $model->form_of_passage == 2;
            }, 'whenClient' => 'function(attribute, value){
            return $("#olimpic-form_of_passage").val() == 2; 
            }'],

            ['time_of_distants_tour_type', 'required', 'when' => function ($model) {
                return $model->number_of_tours == 2;
            }, 'whenClient' => 'function(attribute, value){
            return $("#olimpic-number_of_tours").val() == 2; 
            }'],

            ['form_of_passage', 'required', 'when' => function ($model) {
                return $model->number_of_tours == 1;
            }, 'whenClient' => 'function(attribute, value){
            return $("#olimpic-number_of_tours").val() == 1; 
            }'],

            ['time_of_distants_tour', 'required', 'when' => function ($model) {
                return $model->time_of_distants_tour_type == 1;
            }, 'whenClient' => 'function(attribute, value){
                return $("#olimpic-time_of_distants_tour_type").val() == 1;
            }'],

            ['time_of_tour', 'required', 'when' => function ($model) {
                return $model->form_of_passage == 1;
            }, 'whenClient' => 'function(attribute, value){
            return $("#form_of_passage").val() == 1; 
            }'],


            ['name', 'unique', 'message' => 'Такое название олимпиады уже есть'],
            [['chairman_id', 'number_of_tours', 'form_of_passage', 'edu_level_olymp', 'showing_works_and_appeal',
                'time_of_distants_tour', 'time_of_tour', 'time_of_distants_tour_type', 'prefilling', 'faculty_id', 'only_mpgu_students'], 'integer'],
            [['date_time_start_reg', 'date_time_finish_reg', 'date_time_start_tour'], 'safe'],
            [['competitiveGroupsList', 'classesList'], 'safe'],
            [['address', 'requiment_to_work_of_distance_tour', 'requiment_to_work', 'criteria_for_evaluating_dt', 'criteria_for_evaluating', 'genitive_name'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['chairman_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictChairmans::className(), 'targetAttribute' => ['chairman_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Полное название мероприятия',
            'chairman_id' => 'Председатель оргкомитета',
            'number_of_tours' => 'Количество туров',
            'form_of_passage' => 'Форма проведения',
            'edu_level_olymp' => 'Уровень олимпиады',
            'date_time_start_reg' => 'Дата и время начала регистрации',
            'date_time_finish_reg' => 'Дата и время завершения регистрации',
            'time_of_distants_tour' => 'Продолжительность выполнения заданий заочного (дистанционного) тура в минутах',
            'date_time_start_tour' => 'Дата и время проведения очного тура',
            'address' => 'Адрес проведения очного тура',
            'time_of_tour' => 'Продолжительность выполнения заданий очного тура в минутах',
            'requiment_to_work_of_distance_tour' => 'Требование к выполнению работ заочного (дистанционного) тура',
            'requiment_to_work' => 'Требование к выполнению работ очного тура',
            'criteria_for_evaluating_dt' => 'Критерии оценивания работ заочного (дистанционного) тура',
            'criteria_for_evaluating' => 'Критерии оценивания работ очного тура',
            'showing_works_and_appeal' => 'Показ работ и апелляция',
            'competitiveGroupsList' => 'Выберите конкурсные группы',
            'classesList' => 'Выберите классы и курсы',
            'genitive_name' => 'Название олимпиады/конкурса в родительном падеже',
            'time_of_distants_tour_type' => 'Тип установки времени для прохождения теста дистанционного тура',
            'prefilling' => 'Тип заполнения мероприятия',
            'faculty_id' => 'Учредитель мероприятия',
            'only_mpgu_students' => 'Только для студентов МПГУ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */


    public function getClassAndOlympics()
    {
        return $this->hasMany(ClassAndOlympic::className(), ['olympic_id' => 'id']);
    }

    public static function typeOfTimeDistanceTour()
    {
        return [
            '' => '',
            '1' => 'На выполнение заданий заочного (дистанционного) тура отводится фиксированное время',
            '2' => 'Выполнить задания необходимо до завершения периода регистрации на настоящее Мероприятие',
        ];
    }

    public static function numberOfTours()
    {
        return [
            '' => '',
            '1' => '1 тур',
            '2' => '2 тура',
        ];
    }

    public static function formOfPassage()
    {
        return [
            '' => '',
            '1' => 'очная форма',
            '2' => 'заочная форма',
            '3' => 'Очная и заочная формы',

        ];
    }

    public static function levelOlimp()
    {
        return [
            '' => '',
            '1' => 'Для школьников',
            '2' => 'Для студентов',
        ];
    }


    public static function showingWork()
    {
        return [
            '' => '',
            '1' => 'предусмотрено',
            '2' => 'не предусмотрено',
        ];
    }

    public static function prefilling()
    {
        return [
            '0' => 'основное',
            '1' => 'предварительное',
        ];
    }

    public static function minutePicker()
    {

        $result = [];
        for ($i = 0; $i <= 180; $i++) {
            $result[$i] = $i;
        }
        return $result;


    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasses()
    {
        return $this->hasMany(DictClass::className(), ['id' => 'class_id'])->viaTable('class_and_olympic', ['olympic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChairman()
    {
        return $this->hasOne(DictChairmans::className(), ['id' => 'chairman_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOlimpicCgs()
    {
        return $this->hasMany(OlimpicCg::className(), ['olimpic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitiveGroups()
    {
        return $this->hasMany(DictCompetitiveGroup::className(), ['id' => 'competitive_group_id'])->viaTable('olimpic_cg', ['olimpic_id' => 'id']);
    }

}
