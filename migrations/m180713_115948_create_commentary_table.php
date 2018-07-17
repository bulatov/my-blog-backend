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
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'post_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer()->defaultValue(null),
            'content' => $this->string()->notNull(),
        ]);

        // create index for column `post_id`
        $this->createIndex(
            'idx-commentary-post_id',
            'commentary',
            'post_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-commentary-post_id',
            'commentary',
            'post_id',
            'post',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `post`
        $this->dropForeignKey(
            'fk-commentary-post_id',
            'commentary'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            'idx-commentary-post_id',
            'commentary'
        );

        $this->dropTable('commentary');
    }
}
