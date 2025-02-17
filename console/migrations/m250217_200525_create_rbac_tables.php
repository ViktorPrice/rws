<?php

use yii\db\Migration;

class m250217_200525_create_rbac_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $auth = Yii::$app->authManager;

        // Создание ролей
        if (!$auth->getRole('Администратор')) {
            $admin = $auth->createRole('Администратор');
            $auth->add($admin);
        }

        // Добавление разрешений
        if (!$auth->getPermission('Администратор')) {
            $adminPermission = $auth->createPermission('Администратор');
            $auth->add($adminPermission);
        }

        // Назначение разрешений ролям
        $admin = $auth->getRole('Администратор');
        $adminPermission = $auth->getPermission('Администратор');
        if ($admin && $adminPermission && !$auth->hasChild($admin, $adminPermission)) {
            $auth->addChild($admin, $adminPermission);
        }
    }

    public function down()
    {
        $auth = Yii::$app->authManager;

        $admin = $auth->getRole('Администратор');
        $adminPermission = $auth->getPermission('Администратор');

        if ($admin && $adminPermission && $auth->hasChild($admin, $adminPermission)) {
            $auth->removeChild($admin, $adminPermission);
        }

        if ($adminPermission) {
            $auth->remove($adminPermission);
        }

        if ($admin) {
            $auth->remove($admin);
        }
    }
}