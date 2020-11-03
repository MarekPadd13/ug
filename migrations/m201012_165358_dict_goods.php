<?php

use yii\db\Migration;

/**
 * Class m201012_165304_dict_angle
 */
class m201012_165358_dict_goods extends Migration
{
    private function table() {
        return 'dict_goods';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment("Наименование товара"),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
