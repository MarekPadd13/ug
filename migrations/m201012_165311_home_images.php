<?php

use yii\db\Migration;

/**
 * Class m201012_165311_home_images
 */
class m201012_165311_home_images extends Migration
{
    private function table() {
        return 'home_images';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'angle_id' => $this->integer()->notNull(),
            'home_id' => $this->integer()->notNull(),
            'link' => $this->string()->null(),
            'image' => $this->string()->notNull(),
            'date' => $this->date(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);


        $this->createIndex('{{%idx-dict-angle-angle_id}}', $this->table(), 'angle_id');
        $this->addForeignKey('{{%fk-idx-dict-angle-angle_id}}', $this->table(), 'angle_id','dict_angle', 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-dict-angle-home_id}}', $this->table(), 'home_id');
        $this->addForeignKey('{{%fk-idx-dict-angle-home_id}}', $this->table(), 'home_id' , 'dict_houses', 'id',  'CASCADE', 'RESTRICT');
    }
}
