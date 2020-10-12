<?php

namespace app\modules\sending\models;

use app\models\Profiles;
use app\models\User;

use Yii;

/**
 * This is the model class for table "sending_user_category".
 *
 * @property int $category_id
 * @property int $user_id
 *
 * @property DictSendingUserCategory $category
 * @property User $user
 */
class SendingUserCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sending_user_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'user_id'], 'required'],
            [['category_id', 'user_id'], 'integer'],
            [['category_id', 'user_id'], 'unique', 'targetAttribute' => ['category_id', 'user_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictSendingUserCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(DictSendingUserCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getProfile()
    {
        return $this->hasOne(Profiles::className(), ['user_id' => 'id'])->via('user');
    }
}
