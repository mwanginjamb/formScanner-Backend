<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%documents}}`.
 */
class m220613_222322_add_coordinates_column_to_documents_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%documents}}', 'coordinates', $this->string(64));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%documents}}', 'coordinates');
    }
}
