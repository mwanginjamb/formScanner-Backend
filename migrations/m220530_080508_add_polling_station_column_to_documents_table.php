<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%documents}}`.
 */
class m220530_080508_add_polling_station_column_to_documents_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%documents}}', 'polling_station', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%documents}}', 'polling_station');
    }
}
