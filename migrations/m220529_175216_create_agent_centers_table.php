<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%agent_centers}}`.
 */
class m220529_175216_create_agent_centers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%agent_centers}}', [
            'id' => $this->primaryKey(),
            'agent_id' => $this->integer(),
            'center_id' => $this->integer(),
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
        $this->dropTable('{{%agent_centers}}');
    }
}
