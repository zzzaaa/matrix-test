<?php

use yii\db\Migration;
use yii\db\Schema;

class m170622_155948_createMatrixTable extends Migration
{

    const TABLE = 'matrix';
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'col' =>  'TINYINT UNSIGNED NOT NULL',
            'row' => 'TINYINT UNSIGNED NOT NULL',
            'value' => 'MEDIUMINT UNSIGNED NOT NULL DEFAULT 0']);

        $this->addPrimaryKey('pk', self::TABLE, ['col', 'row']);
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170622_155948_createMatrixTable cannot be reverted.\n";

        return false;
    }
    */
}
