<?php

namespace app\modules\jobs\controllers;

use Yii;
use yii\web\Controller;
use app\models\RefAnswer;
use app\models\RefMembers;
use app\models\SolutionsProfiles;
use app\models\Profiles;

/**
 * Default controller for the `jobs` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = RefAnswer::find()->andWhere(['in', 'legasy_status', [1,2]])->all();

        return $this->render('index',['model' => $model]);
    }

    public function actionView($id)
    {
        $model = RefAnswer::find()->andWhere(['id'=>$id])->one();
        if($model->legasy_status == 1 or $model->legasy_status == 2) {
            return $this->render('view', [
                'model' => $model,
            ]);
        }else{
            return $this->redirect('index');
        }
    }
    public function actionAddMember($id, $position)
        {
            $models = new SolutionsProfiles();
            $models->answer_id = $id;
            $models->member_id = $position;
            $models->profile_id = Yii::$app->user->id;
            $models->save();

            if($models->save()){
                return $this->redirect('index');
            }


        }
}
