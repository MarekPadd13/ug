<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "goods_and_shops".
 *
 * @property int $good_id
 * @property int $shop_id
 *
 * @property DictGoods $good
 * @property DictShops $shop
 */
class GoodsAndShops extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods_and_shops';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['good_id', 'shop_id'], 'required'],
            [['good_id', 'shop_id'], 'integer'],
            [['good_id', 'shop_id'], 'unique', 'targetAttribute' => ['good_id', 'shop_id']],
            [['good_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictGoods::className(), 'targetAttribute' => ['good_id' => 'id']],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictShops::className(), 'targetAttribute' => ['shop_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'good_id' => 'Good ID',
            'shop_id' => 'Shop ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasOne(DictGoods::className(), ['id' => 'good_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(DictShops::className(), ['id' => 'shop_id']);
    }
}
