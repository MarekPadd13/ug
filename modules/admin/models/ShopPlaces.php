<?php

namespace app\modules\admin\models;

use app\modules\admin\behaviors\CurrencyBehavior;
use Yii;

/**
 * This is the model class for table "shop_places".
 *
 * @property int $id
 * @property int $shop_id
 * @property string $address
 * @property int $totalSum
 * @property int $nds10
 * @property int $nds20
 * @property int $date
 * @property int $count
 *
 * @property BuyGoods[] $buyGoods
 * @property DictShops $shop
 */
class ShopPlaces extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_places';
    }

    public function behaviors() {
        return [
            ['class'=> CurrencyBehavior::class,
                'attributes' => ['totalSum', 'nds10', 'nds20']
            ]
        ];

    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shop_id', 'address', 'totalSum', 'date', 'count'], 'required'],
            [['shop_id', 'totalSum', 'nds10', 'nds20', 'date', 'count'], 'integer'],
            [['address'], 'string', 'max' => 255],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictShops::className(), 'targetAttribute' => ['shop_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_id' => 'Магазин',
            'address' => 'Адрес',
            'totalSum' => 'Общая сумма',
            'nds10' => 'НДС 10%',
            'nds20' => 'НДС 20%',
            'date' =>  "Дата",
            'count' => 'Кол-во товаров',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyGoods()
    {
        return $this->hasMany(BuyGoods::className(), ['shop_place_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(DictShops::className(), ['id' => 'shop_id']);
    }

    public function getDateView() {
        return date('d.m.Y H:i:s', $this->date);
    }

}
