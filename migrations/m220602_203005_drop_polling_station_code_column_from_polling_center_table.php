<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%polling_center}}`.
 */
class m220602_203005_drop_polling_station_code_column_from_polling_center_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%polling_center}}', 'polling_station_code');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
