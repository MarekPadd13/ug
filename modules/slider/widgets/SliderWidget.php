<?php
namespace app\modules\slider\widgets;

use app\modules\slider\models\Slider;
use yii\base\Widget;
use yii\base\InvalidConfigException;

/**
 * Class SliderWidget
 * @package app\modules\slider\widgets
 */
class SliderWidget extends Widget
{
    /**
     * @var Slider
     */

    public $id;

    /**
     * @return string
     */
    public function run()
    {   
        $model = $this->findModel($this->id);
    
        $images = $model->getBehavior('galleryBehavior')->getImages();
        
        if ($images) {
            return $this->render('index', [
                'images' => $images,
            ]);
        } else {
            \Yii::$app->session->setFlash('warning', "Картинки не найдены, добавьте их");
            return "";
        }
    }

    protected function findModel($id)
    {
        if (($model = Slider::findOne($id)) !== null) {
            return $model;
        }

         throw new InvalidConfigException('Неверные настройки слайдера');
    }
}
