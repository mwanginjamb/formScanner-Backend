<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%document_line}}`.
 */
class m220530_080539_add_polling_station_id_column_to_document_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%document_line}}', 'polling_station_id', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%document_line}}', 'polling_station_id');
    }
}
