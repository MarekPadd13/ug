<?php

namespace app\modules\admin\controllers\cheque;

use app\modules\admin\models\DictGoodsSearch;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */


class GoodsController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new DictGoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
