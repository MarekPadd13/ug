<?php

use yii\db\Migration;

/**
 * Class  m201012_165311_home_images_add_column
 */
class m201012_165362_shop_places_delete_column extends Migration
{
    private function table() {
        return \app\modules\admin\models\ShopPlaces::tableName();
    }

    public function up()
    {
        $this->dropColumn($this->table(), 'address');
    }
}
