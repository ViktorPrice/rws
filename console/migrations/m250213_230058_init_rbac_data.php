<?php

use yii\db\Migration;

/**
 * Class m250213_230058_init_rbac_data
 */
class m250213_230058_init_rbac_data extends Migration
{
    /**
     * {@inheritdoc}
     */
public function safeUp()
{
    $auth = Yii::$app->authManager;

    // Создание ролей
    $admin = $auth->createRole('Администратор');
    $auth->add($admin);

    $seniorMaster = $auth->createRole('Старший мастер');
    $auth->add($seniorMaster);

    // ... добавьте все остальные роли

    // Назначение роли администратора пользователю с ID 1
    $auth->assign($admin, 1);
}

public function safeDown()
{
    $auth = Yii::$app->authManager;
    $auth->removeAll();
}
}
