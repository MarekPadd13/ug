<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dict_category_doc".
 *
 * @property int $id
 * @property string $name
 */
class DictCategoryDoc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    const TYPELINK = 1;
    const TYPEDOC = 2;

    public static function tableName()
    {
        return 'dict_category_doc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            ['type_id', 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название категории',
            'type_id' => 'Тип категории',
        ];
    }

    public static function typeOfCategory()
    {
        return ['1'=> 'Для ссылок', '2'=> 'Для документов'];
    }
}
