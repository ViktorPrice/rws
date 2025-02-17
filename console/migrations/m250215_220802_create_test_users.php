<?php

use yii\db\Migration;

class m250215_220802_create_test_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $security = Yii::$app->security;
    
        // Список пользователей и их ролей
        $users = [
            [
                'username' => 'admin_test',
                'email' => 'admin@test.com',
                'role' => 'admin'
            ],
            [
                'username' => 'senior_master_test',
                'email' => 'senior_master@test.com',
                'role' => 'senior_master'
            ],
            [
                'username' => 'area_master_test',
                'email' => 'area_master@test.com',
                'role' => 'area_master'
            ],
            [
                'username' => 'technician_test',
                'email' => 'technician@test.com',
                'role' => 'technician'
            ],
            [
                'username' => 'brig_engineer_test',
                'email' => 'brig_engineer@test.com',
                'role' => 'brig_engineer'
            ],
            [
                'username' => 'manager_test',
                'email' => 'manager@test.com',
                'role' => 'manager'
            ],
            [
                'username' => 'supply_test',
                'email' => 'supply@test.com',
                'role' => 'supply'
            ]
        ];
    
        foreach ($users as $userData) {
            // Создание пользователя
            $user = new \common\models\User();
            $user->username = $userData['username'];
            $user->email = $userData['email'];
            $user->password_hash = $security->generatePasswordHash('123456'); // Пароль для всех: 123456
            $user->auth_key = $security->generateRandomString();
            $user->status = \common\models\User::STATUS_ACTIVE;
            $user->save(false); // false чтобы пропустить валидацию
    
            // Назначение роли
            $role = $auth->getRole($userData['role']);
            $auth->assign($role, $user->id);
        }
    }
    
    public function safeDown()
    {
        $usernames = [
            'admin_test',
            'senior_master_test',
            'area_master_test',
            'technician_test',
            'brig_engineer_test',
            'manager_test',
            'supply_test'
        ];
    
        \common\models\User::deleteAll(['username' => $usernames]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250215_220802_create_test_users cannot be reverted.\n";

        return false;
    }
    */
}
