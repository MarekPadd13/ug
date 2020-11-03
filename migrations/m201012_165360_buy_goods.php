<?php

use yii\db\Migration;

/**
 * Class m201012_165304_dict_angle
 */
class m201012_165360_buy_goods extends Migration
{
    private function table() {
        return 'buy_goods';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'shop_place_id' => $this->integer()->notNull(),
            'good_id' => $this->integer()->notNull(),
            'price' => $this->integer()->notNull(),
            'sum' => $this->integer()->notNull(),
            'quantity' => $this->string()->notNull(),
            'nds10' => $this->integer()->null(),
            'nds20' => $this->integer()->null(),
        ], $tableOptions);

        $this->createIndex('{{%idx-buy_goods-shop_place_id}}', $this->table(), 'shop_place_id');
        $this->addForeignKey('{{%fk-idx-buy_goods-shop_place_id}}', $this->table(), 'shop_place_id', 'shop_places', 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-buy_goods-shop_good_id}}', $this->table(), 'good_id');
        $this->addForeignKey('{{%fk-idx-buy_goods-good_id}}', $this->table(), 'good_id', 'dict_goods', 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
