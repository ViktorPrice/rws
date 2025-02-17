<?php

use yii\db\Migration;

class m230101_000001_create_request_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%request}}', [
            'id' => $this->primaryKey(),
            'train_number' => $this->string(50)->notNull(),
            'carriage_number' => $this->string(50),
            'node' => $this->string(50),
            'defect_short' => $this->string(100)->notNull(),
            'defect_full' => $this->string(1000),
            'photo' => $this->string(255),
            'urgency' => $this->string(50)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'deadline_at' => $this->integer()->notNull(),
            'status' => $this->string(50)->notNull(),
            'responsible_id' => $this->integer()->notNull(),
            'qr_code' => $this->string(255),
        ]);

        $this->createIndex(
            'idx-request-responsible_id',
            '{{%request}}',
            'responsible_id'
        );

        $this->addForeignKey(
            'fk-request-responsible_id',
            '{{%request}}',
            'responsible_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%request}}');
    }
}