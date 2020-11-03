<?php

use yii\db\Migration;

/**
 * Class m201012_165304_dict_angle
 */
class m201012_165359_goods_and_shops extends Migration
{
    private function table() {
        return 'goods_and_shops';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'good_id' => $this->integer()->notNull(),
            'shop_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('goods_and_shops-primary', $this->table(), ['shop_id', 'good_id']);
        $this->createIndex('{{%idx-goods_and_shops-shop_id}}', $this->table(), 'shop_id');
        $this->addForeignKey('{{%fk-idx-goods_and_shops-shop_id}}', $this->table(), 'shop_id', 'dict_shops', 'id',  'CASCADE', 'RESTRICT');


        $this->createIndex('{{%idx-goods_and_shops-good_id}}', $this->table(), 'good_id');
        $this->addForeignKey('{{%fk-idx-goods_and_shops-good_id}}', $this->table(), 'good_id', 'dict_goods', 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
