<?php

namespace app\modules\admin\behaviors;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

class CurrencyBehavior extends  Behavior
{
    public $attributes = [];

    /**
     * @var BaseActiveRecord
     */
    public $owner;

    /**
     * @return array
     */
    public function events()
    {
        return [
        ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
        ];
    }


    /**
     * @param $event
     * @throws \yii\base\InvalidConfigException
     */
    public function afterFind($event)
    {
        foreach ($this->attributes as $attribute) {
           $this->owner->$attribute = Yii::$app->formatter->asCurrency($this->owner->$attribute/100, "RUB");
        }



    }


}