<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%candidate}}`.
 */
class m220529_174532_create_candidate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%candidate}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(250),
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
        $this->dropTable('{{%candidate}}');
    }
}
