<?php

namespace app\modules\admin\services;

use app\modules\admin\models\BuyGoods;
use app\modules\admin\models\DictGoods;
use app\modules\admin\models\DictShops;
use app\modules\admin\models\GoodsAndShops;
use app\modules\admin\models\ShopPlaces;


class ChequeService
{
    public function create(array $data){

        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            $shopId = $this->createShopAndGetId($data);
            $placeShopId = $this->createPlaceShopAndGetId($data, $shopId);
            $this->createBayGoods($data['items'], $placeShopId, $shopId);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }


    private function createShopAndGetId(array $data) {

        if(!key_exists('userInn', $data)) {
            throw  new  \RuntimeException('Не найдено ИНН магазина в чеке.');
        }
        $userInn = $data['userInn'];
        $array = ['inn'=> $userInn];
        $nameShop = $this->getNameShop($userInn);
         if($model = DictShops::findOne($array)) {
             return $model->id;
         }else {
             if(!$nameShop) {
                 throw  new  \RuntimeException('Не удалось получить данные об организации.');
             }
             $model = new DictShops($array+['name'=>$nameShop]);
             $model->save();
             return $model->id;
         }
    }

    private function createPlaceShopAndGetId(array $data, $shop_id) {

        if(ShopPlaces::findOne(['shop_id'=> $shop_id, 'date' =>  $data['dateTime']])) {
            throw  new  \RuntimeException('Такой чек загружен в бд.');
        }

        $model = new ShopPlaces([
            'shop_id'=> $shop_id,
            'totalSum' => $data['totalSum'],
            'date' =>  $data['dateTime'],
            'count'=> count($data['items']),
            'nds10' =>  key_exists('nds10', $data) ? $data['nds10'] : 0,
            'nds20' =>  key_exists('nds18', $data) ? $data['nds18'] : 0,
        ]);
        $model->save();
        return $model->id;
    }

    private function createBayGoods(array $data, $shop_place_id, $shop_id) {
        foreach ($data as $goods) {
            $name = trim($goods['name']);
            $name = preg_match('/[:*][0-9]\d/', $name) ? preg_replace("/^(.*?)(\s)(.*?)$/", '\\3', $name) : $name;
            $goodsId = $this->createGoodsAndGetId($name);
            $this->createGoodShop($goodsId, $shop_id);
            $model = new BuyGoods([
                'shop_place_id' =>$shop_place_id,
                'good_id'=> $goodsId,
                'price'=> $goods['price'],
                'sum'=> $goods['sum'],
                'quantity'=> $goods['quantity'],
                'nds10' => key_exists('nds10', $goods) ? $goods['nds10'] : 0,
                'nds20' => key_exists('nds18', $goods) ? $goods['nds18'] : 0,
                ]);
            $model->save(false);
        }
    }

    private function createGoodsAndGetId($name) {
        $array = ['name'=> $name];
        if($model = DictGoods::findOne($array)) {
            return $model->id;
        }else {
            $model = new DictGoods($array);
            $model->save();
            return $model->id;
        }
    }

    private function createGoodShop($good_id, $shop_id) {
        $array = ['good_id'=> $good_id, 'shop_id'=> $shop_id];
        if(!GoodsAndShops::findOne($array)) {
            $model = new GoodsAndShops($array);
            $model->save();
        }
    }

    private function getNameShop($inn) {
        $token = "97116692c956496e352e411373e6472c56fd6aa1";
        $secret = "bd22a07a42deb91a66dfc0529c62ea6ce8b53fdd";
        $dadata = new \Dadata\DadataClient($token, $secret);
        $result = $dadata->findById("party", $inn, 1);

        return is_array($result) ? $result[0]['value'] : null;
    }



}