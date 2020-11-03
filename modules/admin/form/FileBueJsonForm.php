<?php

namespace app\modules\admin\form;

use app\models\DictAngle;
use app\models\HomeImage;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 *
 * @property string| UploadedFile $file
 *
 */
class FileBueJsonForm extends Model
{
    public $file;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['file', 'required'],
            ['file', 'file'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return ['file'=> "Файл Json"];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->file = UploadedFile::getInstance($this, 'file');
            return true;
        }
        return false;
    }

}
