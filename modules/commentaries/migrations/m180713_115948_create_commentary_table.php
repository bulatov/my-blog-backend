<?php

use yii\db\Migration;

/**
 * Handles the creation of table `commentary`.
 */
class m180713_115948_create_commentary_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('commentary', [
            'id' => $this->primaryKey(),
            'content' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'position' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('commentary');
    }
}
