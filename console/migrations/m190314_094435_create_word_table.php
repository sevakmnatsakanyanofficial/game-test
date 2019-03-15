<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%word}}`.
 */
class m190314_094435_create_word_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%word}}', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer()->notNull(),
            'number' => $this->integer()->notNull()->unique(),
            'text' => $this->string()->notNull()
        ]);

        // creates index for column `task_id`
        $this->createIndex(
            'idx-word-task_id',
            'word',
            'task_id'
        );

        // add foreign key for table `task`
        $this->addForeignKey(
            'fk-word-task_id',
            'word',
            'task_id',
            'task',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%word}}');
    }
}
