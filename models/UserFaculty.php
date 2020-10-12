<?php
/**
 * Created by PhpStorm.
 * User: ramil
 * Date: 05/11/2018
 * Time: 19:16
 */

namespace app\models;


use yii\db\ActiveRecord;

class UserFaculty extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_faculty';
    }

    public function rules()
    {
        return [
            [['user_id', 'faculty_id'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'ФИО пользователя',
            'faculty_id' => 'Институт/Факультет',
        ];
    }
}