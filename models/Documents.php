<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "documents".
 *
 * @property int $id
 * @property string $name
 */
class Documents extends \yii\db\ActiveRecord
{
    /**
     * @var \yii\web\UploadedFile
     */
    public $documentFile;

    public static function tableName()
    {
        return 'documents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'documentFile'], 'required'],
            [['name', 'extentions'], 'string'],
            [['category_id'], 'integer'],
            ['documentFile', 'file', 'extensions' => 'docx, doc, pdf', 'maxSize'=> 1024*1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название документа',
            'documentFile' => 'Загрузка документа',
            'category_id' => 'Категория',
        ];
    }



    public function afterSave($insert, $changedAttributes)
    {

        $this->documentFile->saveAs(Yii::getAlias('@webroot').DIRECTORY_SEPARATOR.'documents'.DIRECTORY_SEPARATOR. $this->id.'.'.$this->documentFile->extension);


       parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        $this->deleteFile();

        parent::afterDelete();
    }

    protected function deleteFile()
    {
        return array_map('unlink', glob(Yii::getAlias('@webroot').DIRECTORY_SEPARATOR.'documents'.DIRECTORY_SEPARATOR. $this->id.'.*'));

    }
}
