<?php

use yii\db\Migration;

class m250215_190833_add_user_id_to_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // 1. Добавляем столбец БЕЗ NOT NULL
        $this->addColumn('{{%request}}', 'user_id', $this->integer());
    
        // 2. Присваиваем дефолтное значение (например, ID администратора)
        $adminId = (new \yii\db\Query())
            ->select('id')
            ->from('user')
            ->where(['username' => 'admin'])
            ->scalar();
    
        if ($adminId) {
            $this->update('{{%request}}', ['user_id' => $adminId]);
        }
    
        // 3. Теперь добавляем внешний ключ
        $this->addForeignKey(
            'fk-request-user_id',
            '{{%request}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    
        // 4. Опционально: добавляем NOT NULL после заполнения
        $this->alterColumn('{{%request}}', 'user_id', $this->integer()->notNull());
    }
    
    public function safeDown()
    {
        $this->dropForeignKey('fk-request-user_id', '{{%request}}');
        $this->dropColumn('{{%request}}', 'user_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250215_190833_add_user_id_to_request_table cannot be reverted.\n";

        return false;
    }
    */
}
