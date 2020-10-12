<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $h1
 * @property string $description
 * @property string $page
 * @property string $date_of_publication
 * @property int $status
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['h1', 'description', 'page', 'date_of_publication', 'status'], 'required'],
            [['page'], 'string'],
            [['date_of_publication'], 'safe'],
            [['status'], 'integer'],
            [['h1'], 'string', 'max' => 70],
            [['description'], 'string', 'max' => 120],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'h1' => 'Заголовок (до 70 символов)',
            'description' => 'Краткое описание (до 120 символов)',
            'page' => 'Содержание новости',
            'date_of_publication'=>'Дата публикации',
            'status' => 'Опубликовано',
        ];
    }

}
