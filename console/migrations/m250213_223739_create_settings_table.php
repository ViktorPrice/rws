<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%settings}}`.
 */
class m250213_223739_create_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
public function safeUp()
{
    $this->createTable('{{%settings}}', [
        'id' => $this->primaryKey(),
        'key' => $this->string(50)->notNull()->unique(),
        'value' => $this->text(),
        'defect_short' => $this->string(255),
        'created_at' => $this->integer()->notNull(),
        'updated_at' => $this->integer()->notNull(),
    ]);

    // Добавляем базовые настройки
    $this->batchInsert('{{%settings}}', 
        ['key', 'value', 'defect_short', 'created_at', 'updated_at'], 
        [
            [
                'default_deadline_hours', 
                '12', 
                'Срок закрытия заявки по умолчанию (в часах)',
                time(),
                time()
            ],
            [
                'max_reassignments', 
                '3', 
                'Максимальное количество переназначений',
                time(),
                time()
            ],
            [
                'notification_channels', 
                'email,push', 
                'Каналы уведомлений (через запятую)',
                time(),
                time()
            ]
        ]
    );
}

public function safeDown()
{
    $this->dropTable('{{%settings}}');
}
}
