<?php

use yii\db\Migration;

/**
 * Class  m201012_165311_home_images_add_column
 */
class m201012_165365_user_appart_add_column extends Migration
{
    private function table() {
        return \app\models\UserHouseApart::tableName();
    }

    public function up()
    {
        $this->alterColumn($this->table(), 'type', $this->integer(1)->defaultValue(1)->null());
    }
}
