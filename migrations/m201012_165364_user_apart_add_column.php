<?php

use yii\db\Migration;

/**
 * Class  m201012_165311_home_images_add_column
 */
class m201012_165364_user_apart_add_column extends Migration
{
    private function table() {
        return \app\models\UserHouseApart::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'type', $this->integer(1)->null()->comment("Тип помещения"));
        $this->addColumn($this->table(), 'entrance', $this->integer()->null()->comment("Подъезд"));
        $this->addColumn($this->table(), 'floor', $this->integer()->null()->comment("Этаж"));
        $this->addColumn($this->table(), 'sq', $this->float()->null()->comment("Кв"));
    }
}
