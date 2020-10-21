<?php

use yii\db\Migration;

/**
 * Class m201012_165355_end_home_build
 */
class m201012_165355_end_home_build extends Migration
{
    private function table() {
        return 'end_home_build';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'home_id' => $this->integer()->notNull(),
            'number' => $this->integer(3)->defaultValue(0),
            'date' => $this->date(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);


        $this->createIndex('{{%idx-end_home_build-home_id}}', $this->table(), 'home_id');
        $this->addForeignKey('{{%fk-idx-end_home_build-home_id}}', $this->table(), 'home_id' , 'dict_houses', 'id',  'CASCADE', 'RESTRICT');
    }
}
