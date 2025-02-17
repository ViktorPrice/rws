<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%roles}}`.
 */
class m250213_165041_create_roles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
public function safeUp()
{
    // Таблица ролей
    $this->createTable('{{%role}}', [
        'id' => $this->primaryKey(),
        'name' => $this->string()->notNull()->unique(),
    ]);

    // Связь пользователей и ролей
    $this->createTable('{{%user_role}}', [
        'user_id' => $this->integer()->notNull(),
        'role_id' => $this->integer()->notNull(),
    ]);

    // Внешние ключи
    $this->addForeignKey(
        'fk-user_role-user_id',
        '{{%user_role}}',
        'user_id',
        '{{%user}}',
        'id',
        'CASCADE',
        'CASCADE'
    );

    $this->addForeignKey(
        'fk-user_role-role_id',
        '{{%user_role}}',
        'role_id',
        '{{%role}}',
        'id',
        'CASCADE',
        'CASCADE'
    );

    // Добавим базовые роли
    $this->batchInsert('{{%role}}', ['name'], [
        ['Администратор'],
        ['Старший мастер'],
        ['Мастер участка'],
        ['Техник'],
        ['Бригадир'],
        ['Инженер'],
        ['Менеджер'],
        ['Снабжение'],
    ]);
}

public function safeDown()
{
    $this->dropTable('{{%user_role}}');
    $this->dropTable('{{%role}}');
}
}
