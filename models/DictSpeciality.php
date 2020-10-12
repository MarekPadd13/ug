<?php

namespace app\models;

/**
 * This is the model class for table "dict_speciality".
 *
 * @property int $id
 * @property string $code
 * @property int $name
 *
 * @property-read string $codeWithName
 */
class DictSpeciality extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_speciality';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['name'], 'string'],
            [['code'], 'string', 'max' => 8],
            ['code', 'unique', 'message' => 'Такой направление подготовки уже есть'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Код',
            'name' => 'Название',
        ];
    }

    public function getCodeWithName()
    {
        return $this->code . ' - ' . $this->name;
    }
}
