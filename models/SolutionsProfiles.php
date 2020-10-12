<?php
/**
 * Created by PhpStorm.
 * User: ramil
 * Date: 23.09.2018
 * Time: 21:35
 */

namespace app\models;


class SolutionsProfiles extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'solutions_profiles';
    }

    public function rules()
    {
        return[
            [['answer_id', 'member_id', 'user_id'], 'required'],
        ];
    }
}