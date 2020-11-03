<?php

namespace app\modules\admin\controllers\cheque;

use app\modules\admin\models\DictGoodsSearch;
use app\modules\admin\models\DictShops;
use app\modules\admin\models\DictShopSearch;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class ShopController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new DictShopSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
