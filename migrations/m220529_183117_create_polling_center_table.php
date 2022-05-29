<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%polling_center}}`.
 */
class m220529_183117_create_polling_center_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%polling_center}}', [
            'id' => $this->primaryKey(),
            'county_code' => $this->integer(),
            'county_name' => $this->string(30),
            'constituency_code' => $this->integer(),
            'constituency_name' => $this->string(150),
            'caw_code' => $this->integer(),
            'caw_name' => $this->string(),
            'registration_center_name' => $this->string(150),
            'voters_per_registration_center' => $this->integer(10),
            'polling_station_code' => $this->integer(25),
            'polling_station_name' => $this->string(150),
            'voters_per_polling_station' => $this->integer(10),
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
        $this->dropTable('{{%polling_center}}');
    }
}
