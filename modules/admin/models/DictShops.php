<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "dict_shops".
 *
 * @property int $id
 * @property string $name Наименование магазина
 * @property string $inn
 *
 * @property GoodsAndShops[] $goodsAndShops
 * @property DictGoods[] $goods
 * @property ShopPlaces[] $shopPlaces
 */
class DictShops extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_shops';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'inn'], 'required'],
            [['name', 'inn'], 'string', 'max' => 255],
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
            'inn' => "ИНН"
        ];
    }

    public static function allColumn() {
        return self::find()
            ->select('name, id')
            ->orderBy(['name'=> SORT_ASC])
            ->indexBy('id')->column();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsAndShops()
    {
        return $this->hasMany(GoodsAndShops::className(), ['shop_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getGoods()
    {
        return $this->hasMany(DictGoods::className(), ['id' => 'good_id'])->viaTable('goods_and_shops', ['shop_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopPlaces()
    {
        return $this->hasMany(ShopPlaces::className(), ['shop_id' => 'id']);
    }
}
