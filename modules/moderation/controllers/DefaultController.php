<?php

namespace app\modules\moderation\controllers;

use yii\web\Controller;
use app\models\Profiles;
use \mdm\admin\models\User;
use app\models\RefProblems;
use app\models\RefAnswer;
use app\models\RefMembers;
use app\models\RefDoljnost;

/**
 * Default controller for the `moderation` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $profiles = Profiles::find()->andWhere(['confirm'=>true])->count();
        $problems = RefProblems::find()->andWhere(['moderation'=> true])->count();

        return $this->render('index',[
            'profiles' => $profiles,
            'problems' => $problems,

        ]);
    }
}
