<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%result}}`.
 */
class m190314_161959_create_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%result}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),

            'win' => $this->integer(),
            'lose' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-result-user_id',
            'result',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-result-user_id',
            'result',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%result}}');
    }
}
