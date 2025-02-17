<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%status_history}}`.
 */
class m250215_070106_create_status_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('status_history', [
            'id' => $this->primaryKey(),
            'request_id' => $this->integer()->notNull(),
            'status' => $this->string()->notNull(),
            'comment' => $this->text(),
            'created_at' => $this->datetime()->notNull(),
        ]);
    
        // Внешний ключ к таблице request
        $this->addForeignKey(
            'fk-status_history-request_id',
            'status_history',
            'request_id',
            'request',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }
    
    public function safeDown()
    {
        $this->dropForeignKey('fk-status_history-request_id', 'status_history');
        $this->dropTable('status_history');
    }
}
