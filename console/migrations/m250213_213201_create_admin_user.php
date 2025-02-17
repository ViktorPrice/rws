<?php

use yii\db\Migration;

/**
 * Class m250213_213201_create_admin_user
 */
class m250213_213201_create_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
public function safeUp()
{
    // Создание пользователя
    $this->insert('user', [
        'username' => 'admin',
        'email' => 'admin@example.com',
        'password_hash' => Yii::$app->security->generatePasswordHash('P@ssw0rd'),
        'auth_key' => Yii::$app->security->generateRandomString(),
        'status' => 10, // User::STATUS_ACTIVE
        'created_at' => time(),
        'updated_at' => time(),
    ]);

    // Назначение роли
    $userId = Yii::$app->db->getLastInsertID();
    $this->insert('user_role', [
        'user_id' => $userId,
        'role_id' => 1,
    ]);
}

public function safeDown()
{
    $this->delete('user', ['username' => 'admin']);
}
}
