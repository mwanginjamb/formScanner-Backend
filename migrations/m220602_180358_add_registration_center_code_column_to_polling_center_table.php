<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%polling_center}}`.
 */
class m220602_180358_add_registration_center_code_column_to_polling_center_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%polling_center}}', 'registration_center_code', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%polling_center}}', 'registration_center_code');
    }
}
