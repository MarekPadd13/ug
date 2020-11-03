<?php

use yii\db\Migration;

/**
 * Class m201012_165304_dict_angle
 */
class m201012_165357_shop_places extends Migration
{
    private function table() {
        return 'shop_places';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer()->notNull(),
            'address' => $this->string()->notNull(),
            'totalSum' => $this->integer()->notNull(),
            'nds10' => $this->integer()->null(),
            'nds20' => $this->integer()->null(),
            'date' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-shop_places-shop_id}}', $this->table(), 'shop_id');
        $this->addForeignKey('{{%fk-idx-shop_places-shop_id}}', $this->table(), 'shop_id', 'dict_shops', 'id',  'CASCADE', 'RESTRICT');


    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
