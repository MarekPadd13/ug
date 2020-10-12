<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "links".
 *
 * @property int $id
 * @property string $name
 * @property string $href
 */
class Links extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'links';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'href'], 'required'],
            [['name', 'href'], 'string'],
            ['category_id','integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название ссылки',
            'href' => 'Ссылка',
            'category_id' => 'Категория',
        ];
    }
}
