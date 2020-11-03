<?php

use yii\db\Migration;

/**
 * Class m201012_165304_dict_angle
 */
class m201012_165356_dict_shops extends Migration
{
    private function table() {
        return 'dict_shops';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment("Наименование магазина"),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
