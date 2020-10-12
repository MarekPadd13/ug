<?php

namespace app\models;

use app\modules\admin\form\HomeImageForm;
use modules\usecase\ImageUploadBehaviorYiiPhp;
use phpbb\session;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * This is the model class for table "home_images".
 *
 * @property int $id
 * @property int $status
 * @property int $angle_id
 * @property int $home_id
 * @property int $created_at
 * @property int $updated_at
 * @property string $date
 * @property string $image
 * @property string $link
 *
 */
class  HomeImage extends \yii\db\ActiveRecord
{

    const STATUS_DEFAULT = 0;
    const STATUS_PUBLISHED = 1;

    public static function tableName()
    {
        return 'home_images';
    }

    public static function create(HomeImageForm $form) {
        $homeImage = new static();
        $homeImage->data($form);
        return $homeImage;
    }

    public function data(HomeImageForm $form)
    {
        $this->angle_id = $form->angle_id;
        if($form->image) {
            $this->setImage($form->image);
        }
        $this->link = $form->link;
        $this->home_id = $form->home_id;
        $this->date = $form->date;

    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status'=> "Статус",
            'statusName'=> "Статус",
            'date'=> 'Дата создания',
            'angle_id' => "Ракурс",
            'home_id' => "Номер дома",
            'image' => "Фото",
            'link' => 'Ссылка на источник',
            'name' => "Новое название ракурса",
        ];
    }

    public static  function statusList() {
        return [
            self::STATUS_DEFAULT => "Не опубликован",
            self::STATUS_PUBLISHED => "Опубликован",
        ];
    }

    public function getStatusName () {
        return self::statusList()[$this->status];
    }


    public function getHome() {
        return $this->hasOne(DictHouses::class, ['id'=> 'home_id']);
    }

    public function getAngle() {
        return $this->hasOne(DictAngle::class, ['id'=> 'angle_id']);
    }

    public function setImage(UploadedFile $file): void
    {
        $this->image = $file;
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'image',
                'filePath' => '@webroot/uploads/[[pk]].[[extension]]',
                'fileUrl' => '/uploads/[[pk]].[[extension]]'
            ]
        ];
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

}
