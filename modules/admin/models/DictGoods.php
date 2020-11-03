<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "dict_goods".
 *
 * @property int $id
 * @property string $name Наименование товара
 *
 * @property BuyGoods[] $buyGoods
 * @property GoodsAndShops[] $goodsAndShops
 * @property DictShops[] $shops
 */
class DictGoods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyGoods()
    {
        return $this->hasMany(BuyGoods::className(), ['good_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsAndShops()
    {
        return $this->hasMany(GoodsAndShops::className(), ['good_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getShops()
    {
        return $this->hasMany(DictShops::className(), ['id' => 'shop_id'])->viaTable('goods_and_shops', ['good_id' => 'id']);
    }

    public function getShopsName() {
        $result ="";
        foreach ($this->shops as $shop) {
            $result.=$shop->name."; ";
        }
        return $result;
    }
}
