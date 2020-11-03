<?php

namespace app\controllers;

use app\modules\admin\form\FileBueJsonForm;
use app\modules\admin\services\ChequeService;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class ChequeController extends Controller
{
    public $service;


    public function __construct($id, $module, ChequeService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }


    /**
     * Creates a new Stream model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAdd()
    {
        $form = new FileBueJsonForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->saveAsFile($form->file);
                $this->service->create($this->dataJsonFile($form->file));
                Yii::$app->session->setFlash('success','Успешно загружено' );
            }catch (\RuntimeException $e) {
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
            $this->deleteFile($form->file);
            return $this->redirect(['add']);
        }

        return $this->render('add', [
            'model' => $form,
        ]);

    }

    private function filePath(UploadedFile $file) {

        return Yii::getAlias('@webroot').'/json/' . $file->baseName . '.' . $file->extension;
    }

    private function saveAsFile(UploadedFile $file) {
        if($file->extension != "json") {
         throw  new  \RuntimeException('Файл не является json.');
        }
        $file->saveAs($this->filePath($file));
    }


    private function dataJsonFile(UploadedFile $file) {
        return Json::decode($this->renderFile($this->filePath($file)));
    }


    private function deleteFile(UploadedFile $file) {
         unlink($this->filePath($file));
    }


}
