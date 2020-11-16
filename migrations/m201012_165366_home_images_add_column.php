<?php

use yii\db\Migration;

/**
 * Class  m201012_165311_home_images_add_column
 */
class m201012_165366_home_images_add_column extends Migration
{
    private function table() {
        return 'home_images';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'published', $this->integer(1)->defaultValue(0));
        $this->addColumn($this->table(), 'description', $this->text()->null());
    }
}
