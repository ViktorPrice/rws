<?php

use yii\db\Migration;

class m230101_000002_update_request_table extends Migration
{
    public function safeUp()
    {
        // Убедимся, что поле deadline_at существует
        if ($this->db->schema->getTableSchema('{{%request}}')->getColumn('deadline_at') !== null) {
            // Изменяем поле deadline_at, чтобы оно было обязательным
            $this->alterColumn('{{%request}}', 'deadline_at', $this->integer()->notNull());
        }
    }

    public function safeDown()
    {
        // Возвращаем поле deadline_at к необязательному
        $this->alterColumn('{{%request}}', 'deadline_at', $this->integer());
    }
}