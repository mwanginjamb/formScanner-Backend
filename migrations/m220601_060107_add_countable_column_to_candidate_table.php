<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%candidate}}`.
 */
class m220601_060107_add_countable_column_to_candidate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%candidate}}', 'countable', $this->integer(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%candidate}}', 'countable');
    }
}
