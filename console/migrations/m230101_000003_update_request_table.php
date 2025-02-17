<?php

use yii\db\Migration;

class m230101_000003_update_request_table extends Migration
{
public function safeUp()
{
    // Устанавливаем значение по умолчанию для responsible_id (например, ID пользователя по умолчанию)
    $this->alterColumn('{{%request}}', 'responsible_id', $this->integer()->notNull()->defaultValue(1));
}

public function safeDown()
{
    $this->alterColumn('{{%request}}', 'responsible_id', $this->integer());
}
}