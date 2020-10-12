<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "managment_profiles".
 *
 * @property int $id
 * @property int $user_id
 * @property string $last_name фамилия
 * @property string $first_name имя
 * @property string $patronymic отчество
 * @property string $phone телефон
 * @property string $email почта
 * @property string $post должность
 * @property int $dict_faculty_id id института/факультета
 */
class ManagmentProfiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'managment_profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'last_name', 'first_name', 'patronymic', 'phone', 'email', 'post', 'dict_faculty_id'], 'required'],
            [['user_id', 'dict_faculty_id'], 'integer'],
            [['last_name', 'first_name', 'patronymic', 'email', 'post'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 17],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'patronymic' => 'Patronymic',
            'phone' => 'Phone',
            'email' => 'Email',
            'post' => 'Post',
            'dict_faculty_id' => 'Dict Faculty ID',
        ];
    }
}
