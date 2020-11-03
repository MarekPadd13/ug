<?php

namespace app\modules\admin\controllers\cheque;

use app\modules\admin\models\ShopPlaces;
use app\modules\admin\models\ShopPlacesSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 *  controller for the `admin` module
 */
class PlaceShopController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new ShopPlacesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single  ShopPlaces  model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the  ShopPlaces model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopPlaces the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopPlaces::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
