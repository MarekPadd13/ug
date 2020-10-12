<?php

use yii\db\Migration;

/**
 * Class m190409_061458_slider
 */
class m190409_061458_slider extends Migration
{
    private $tableName = '{{%slider}}'; 
    
     public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()
        ], $options);

        $this->insert($this->tableName, [
            'id' => 1,
            'name' => 'index'
        ]);

    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
  

}
