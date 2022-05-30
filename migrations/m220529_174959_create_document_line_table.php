<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%document_line}}`.
 */
class m220529_174959_create_document_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%document_line}}', [
            'id' => $this->primaryKey(),
            'candidate_id' => $this->integer(),
            'votes' => $this->integer(10),
            'polling_station_id' => $this->string(30),
            'created_at' => $this->integer(25),
            'updated_at' => $this->integer(25),
            'created_by' => $this->integer(25),
            'updated_by' => $this->integer(25),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%document_line}}');
    }
}
