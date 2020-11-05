<?php

use yii\db\Migration;

/**
 * Class  m201012_165311_home_images_add_column
 */
class m201012_165363_dict_shop_add_column extends Migration
{
    private function table() {
        return \app\modules\admin\models\DictShops::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'inn', $this->string()->null());
        $this->alterColumn($this->table(), 'name', $this->string()->null());
    }
}
