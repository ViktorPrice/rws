<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m250215_072356_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            'request_id' => $this->integer()->notNull(), // Связь с заявкой
            'author_id' => $this->integer()->notNull(),  // Связь с пользователем (автор комментария)
            'text' => $this->text()->notNull(),          // Текст комментария
            'created_at' => $this->integer()->notNull(), // Дата создания
        ]);
    
        // Внешние ключи
        $this->addForeignKey(
            'fk-comment-request_id',
            'comment',
            'request_id',
            'request',
            'id',
            'CASCADE',
            'CASCADE'
        );
    
        $this->addForeignKey(
            'fk-comment-author_id',
            'comment',
            'author_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }
    
    public function safeDown()
    {
        $this->dropForeignKey('fk-comment-request_id', 'comment');
        $this->dropForeignKey('fk-comment-author_id', 'comment');
        $this->dropTable('comment');
    }
}
