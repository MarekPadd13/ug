<?php

namespace app\modules\slider\models;
use zxbodya\yii2\galleryManager\GalleryBehavior;

use Yii;

/**
 * This is the model class for table "slider".
 *
 * @property int $id
 * @property string $name
 */
class Slider extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'slider';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название слайдера на латиниском',
        ];
    }

    public function behaviors()
    {
        return [
             'galleryBehavior' => [
                 'class' => GalleryBehavior::className(),
                 'type' => 'slider',
                 'extension' => 'jpg',
                 'directory' => Yii::getAlias('@webroot') . '/images/slider/gallery',
                 'url' => Yii::getAlias('@web') . '/images/slider/gallery',
                 'versions' => [
                     'small' => function ($img) {
                         /** @var \Imagine\Image\ImageInterface $img */
                         return $img
                             ->copy()
                             ->thumbnail(new \Imagine\Image\Box(200, 200));
                     },
                     'medium' => function ($img) {
                         /** @var \Imagine\Image\ImageInterface $img */
                         $dstSize = $img->getSize();
                         $maxWidth = 800;
                         if ($dstSize->getWidth() > $maxWidth) {
                             $dstSize = $dstSize->widen($maxWidth);
                         }
                         return $img
                             ->copy()
                             ->resize($dstSize);
                     },
                 ]
             ]
        ];
    }
}
