<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%polling_center}}`.
 */
class m220602_203320_add_polling_station_code_column_to_polling_center_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%polling_center}}', 'polling_station_code', $this->string(30));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%polling_center}}', 'polling_station_code');
    }
}
