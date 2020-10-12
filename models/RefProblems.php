<?php

namespace app\models;

use Yii;

class RefProblems extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ref_problems';
    }

    public function rules()
    {
        return[
            [['name', 'description', 'full_text'], 'required'],
            [['name', 'full_text'], 'string'],
            ['description', 'string', 'max'=> '255'],
        ];
    }

    public function attributeLabels()
    {
        return[
            'name' => 'Название',
            'description' => 'Краткое описание',
            'full_text' => 'Подробный текст',
        ];
    }

        public function getRefProblemUser()
    {
        return $this->hasMany(RefProblemsUser::className(), ['ref_problems_id' => 'id']);
    }

     public function getIsAnswers() {

     return $this->getRefProblemUser()->andWhere(['ref_problems_user.user_id' => Yii::$app->user->id])->one();
        }


        public function getProfile()
        {
            return $this->hasOne(Profiles::className(), ['user_id' => 'user_id']);
        }


}
