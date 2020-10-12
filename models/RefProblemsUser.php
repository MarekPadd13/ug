<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_problems_user".
 *
 * @property int $ref_problems_id
 * @property int $user_id
 * @property int $ref_ball
 *
 * @property RefProblems $refProblems
 * @property User $user
 */
class RefProblemsUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_problems_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ref_problems_id', 'user_id', 'ref_ball'], 'required'],
            [['ref_problems_id', 'user_id', 'ref_ball'], 'integer'],
            [['ref_problems_id', 'user_id', 'ref_ball'], 'unique', 'targetAttribute' => ['ref_problems_id', 'user_id', 'ref_ball']],
            [['ref_problems_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefProblems::className(), 'targetAttribute' => ['ref_problems_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ref_problems_id' => 'Ref Problems ID',
            'user_id' => 'User ID',
            'ref_ball' => 'Ref Ball',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefProblems()
    {
        return $this->hasOne(RefProblems::className(), ['id' => 'ref_problems_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
