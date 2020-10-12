<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "letters".
 *
 * @property int $id
 * @property string $name
 * @property string $link
 *
 * @property CollectionsOfSignarutes[] $collectionsOfSignarutes
 */
class Letters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'letters';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'link'], 'required'],
            [['link'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'link' => 'Link',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollectionsOfSignarutes()
    {
        return $this->hasMany(CollectionsOfSignarutes::className(), ['letters_id' => 'id']);
    }
}
