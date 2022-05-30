<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%user}}`.
 */
class m220530_222008_drop_email_column_from_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%user}}','email');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
