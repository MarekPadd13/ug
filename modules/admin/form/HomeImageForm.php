<?php

namespace app\modules\admin\form;

use app\models\DictAngle;
use app\models\HomeImage;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 *
 * @property int $id
 * @property int $angle_id
 * @property int $home_id
 * @property int $date_visible
 * @property string $date
 * @property string $image
 * @property string $link
 *
 */
class HomeImageForm extends Model
{
    public $name, $link, $image, $angle_id, $date, $date_visible, $home_id, $description;

    public $ajax = false;
    const SCENARIO_UPDATE = 1;
    const ANGLE_NEW = 0;


    public function __construct(HomeImage $homeImage = null, $config = [])
    {
        if($homeImage) {
            $this->setAttributes($homeImage->getAttributes());
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['link', 'date', 'home_id', 'angle_id'], 'required'],
            [['link', 'angle_id'], 'trim'],
            [['name'], 'required', 'when' => function ($model) {
               return $model->angle_id == 0;
            },   'whenClient' => 'function (attribute, value) { return $("#homeimageform-angle_id").val() == 0}'],
            [['link','name'], 'string', 'max' => 255],
            [['description'], 'string'],
            ['name', 'unique', 'targetClass' => DictAngle::class, 'message' => 'Такой ракурс уже есть в списке'],
            [['home_id', 'angle_id', 'date_visible'], 'integer'],
            [['date'], 'date', 'format' => "yyyy-mm-dd"],
            ['image', 'required', 'except' => self::SCENARIO_UPDATE],
            ['image', 'image',
                'minHeight' => 300,
                'extensions' => 'jpg, png, jpeg',
                'maxSize' => 1024 * 1024 * 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new HomeImage())->attributeLabels();
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->image = UploadedFile::getInstance($this, 'image');
            return true;
        }
        return false;
    }

}
