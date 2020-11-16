<?php

namespace app\modules\admin\services;

use app\models\DictAngle;
use app\models\HomeImage;
use app\modules\admin\form\HomeImageForm;

class HomeImageService
{

    public function create(HomeImageForm $form){
        $form->angle_id = $this->angleID($form) ?? $form->angle_id;
        $model = HomeImage::create($form);
        $this->save($model);
        return $model;
    }

    public function edit(HomeImage $model, HomeImageForm $form)
    {
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            $form->angle_id = $this->angleID($form) ?? $form->angle_id;
            $model->data($form);
            $this->save($model);
            $transaction->commit();
            return $model;
        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    public function status(HomeImage $model, $status)
    {
        $model->setStatus($status);
        $this->save($model);
    }

    public function published(HomeImage $model, $published)
    {
        $model->setPublished($published);
        $this->save($model);
    }


    protected function save(HomeImage $homeImage)
    {
        if (!$homeImage->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }

    }

    protected function angleID(HomeImageForm $model)
    {
        if($model->name && $model->angle_id == HomeImageForm::ANGLE_NEW) {
            $dictAngle = new DictAngle();
            $dictAngle->name = $model->name;
            $dictAngle->save();
            return $dictAngle->id;
        }
        return null;
    }



}