<?php

namespace app\modules\admin\models;

use app\modules\admin\behaviors\CurrencyBehavior;
use Yii;

/**
 * This is the model class for table "buy_goods".
 *
 * @property int $id
 * @property int $shop_place_id
 * @property int $good_id
 * @property int $price
 * @property int $sum
 * @property string $quantity
 * @property int $nds10
 * @property int $nds20
 *
 * @property DictGoods $good
 * @property ShopPlaces $shopPlace
 */
class BuyGoods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'buy_goods';
    }

    public function behaviors() {
        return [
            ['class'=> CurrencyBehavior::class,
                'attributes' => ['sum', 'price', 'nds10', 'nds20']
            ]
        ];

    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shop_place_id', 'good_id', 'price', 'sum', 'quantity'], 'required'],
            [['shop_place_id', 'good_id', 'price', 'sum', 'nds10', 'nds20'], 'integer'],
            [['quantity'], 'string', 'max' => 255],
            [['good_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictGoods::className(), 'targetAttribute' => ['good_id' => 'id']],
            [['shop_place_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopPlaces::className(), 'targetAttribute' => ['shop_place_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_place_id' => 'Shop Place ID',
            'good_id' => 'Товар',
            'price' => 'Стоимость',
            'sum' => 'Сумма',
            'quantity' => 'Количество',
            'nds10' => 'НДС 10%',
            'nds20' => 'НДС 20%',
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
    public function getShopPlace()
    {
        return $this->hasOne(ShopPlaces::className(), ['id' => 'shop_place_id']);
    }
}
