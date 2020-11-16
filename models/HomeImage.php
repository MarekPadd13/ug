<?php

namespace app\models;

use app\modules\admin\behaviors\ImageUploadBehaviorYiiPhp;
use app\modules\admin\form\HomeImageForm;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "home_images".
 *
 * @property int $id
 * @property int $status
 * @property int $angle_id
 * @property int $home_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $date_visible
 * @property int $published
 * @property string $description
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
        $this->date_visible = $form->date_visible;
        $this->description = $form->description;

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
            'date'=> 'Дата съемки',
            'angle_id' => "Ракурс",
            'home_id' => "Номер дома",
            'image' => "Фото",
            'date_visible' => "Показывать дату?",
            'dateVisibleName' => "Показывать дату?",
            'link' => 'Ссылка на источник',
            'name' => "Новое название ракурса",
            'description'=> "Краткое описание, что изменилось.",
            'published'=> "Опубликовать текст?",
            'publishedName'=> "Опубликовать текст?",
        ];
    }

    public static  function statusList() {
        return [
            self::STATUS_DEFAULT => "Не опубликован",
            self::STATUS_PUBLISHED => "Опубликован",
        ];

    }

    public static  function dateVisibleList() {
            return [
                "Нет",
                "Да",
            ];
        }

    public function getStatusName () {
        return self::statusList()[$this->status];
    }

    public function getPublishedName () {
        return self::statusList()[$this->published];
    }

    public function getDateVisibleName () {
        return self::dateVisibleList()[$this->date_visible];
    }

    public function getDateView() {
        return date('d.m.Y', strtotime($this->date));
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
            [
                'class' => ImageUploadBehaviorYiiPhp::class,
                'attribute' => 'image',
                'filePath' => '@webroot/uploads/[[pk]].[[extension]]',
                'fileUrl' => '/uploads/[[pk]].[[extension]]',
                'thumbPath' => '@webroot/uploads/cache/[[profile]]_[[pk]].[[extension]]',
                'thumbUrl' => '/uploads//cache/[[profile]]_[[pk]].[[extension]]',
                'thumbs' => [
                    'preview' => ['width' => 100, 'height' => 100],
                ],
            ],
            TimestampBehavior::class,
        ];
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setPublished($published)
    {
        $this->published = $published;
    }

}
