<?php

namespace app\models;

use Yii;
use yii\web\Response;

/**
 * This is the model class for table "dict_class".
 *
 * @property int $id
 * @property string $name
 * @property int $type Школа/СПО/ВУЗ
 *
 * @property ClassAndOlympic[] $classAndOlympics
 * @property Olympiс[] $olympics
 */
class DictClass extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const SCHOOL = 1;
    const COLLEDGE = 2;
    const HIGHSCHOOL = 3;

    public static function tableName()
    {
        return 'dict_class';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type'], 'integer'],
            [['name'], 'string', 'max' => 56],
            [['name'], 'unique', 'targetAttribute' => ['name', 'type']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Номер',
            'type' => 'Тип',
        ];
    }

    public static function typeOfClass()
    {
        return [
            '1' => 'класс школы',
            '2' => 'курс колледжа/техникума',
            '3' => 'курс вуза',
        ];
    }

    public static function classes()
    {
        $result = [];
        for ($i = 1; $i <= 11; $i++) {
            $result[$i] = $i;

        }

        return $result;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassAndOlympics()
    {
        return $this->hasMany(ClassAndOlympic::className(), ['class_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOlympics()
    {
        return $this->hasMany(Olimpiс::className(), ['id' => 'olympic_id'])->viaTable('class_and_olympic', ['class_id' => 'id']);
    }

}
