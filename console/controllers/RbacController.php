<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\User;
use yii\rbac\DbManager;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); // Очистка старых данных

        // Создаем разрешения
        $manageUsers = $this->createPermission('manageUsers', 'Управление пользователями');
        $manageRequests = $this->createPermission('manageRequests', 'Управление заявками');
        $manageRoles = $this->createPermission('manageRoles', 'Управление ролями');
        $viewAnalytics = $this->createPermission('viewAnalytics', 'Просмотр аналитики');
        $createRequests = $this->createPermission('createRequests', 'Создание заявок');
        $assignRequests = $this->createPermission('assignRequests', 'Назначение заявок');
        $verifyQuality = $this->createPermission('verifyQuality', 'Проверка качества работ');
        $manageSupplies = $this->createPermission('manageSupplies', 'Управление снабжением');
        $viewRequests = $this->createPermission('viewRequests', 'Просмотр заявок');
        $manageAutomation = $this->createPermission('manageAutomation', 'Управление АСУ');

        // Создаем роли
        $admin = $this->createRole('admin', 'Полный доступ ко всем функциям', 'Администратор');
        $seniorMaster = $this->createRole('senior_master', 'Контроль всех заявок', 'Старший мастер');
        $areaMaster = $this->createRole('area_master', 'Управление заявками на участке', 'Мастер участка');
        $technician = $this->createRole('technician', 'Создание и работа с заявками', 'Техник');
        $brigEngineer = $this->createRole('brig_engineer', 'Выполнение назначенных работ', 'Бригадир/Инженер');
        $manager = $this->createRole('manager', 'Просмотр и отчетность', 'Менеджер');
        $supply = $this->createRole('supply', 'Управление поставками', 'Снабжение');

        // Назначение разрешений ролям
        $this->assignPermissions($admin, [
            $manageUsers, $manageRoles, $manageRequests, 
            $viewAnalytics, $assignRequests, $verifyQuality,
            $manageSupplies, $viewRequests, $manageAutomation
        ]);

        $this->assignPermissions($seniorMaster, [
            $manageRequests, $assignRequests, $verifyQuality, $viewRequests
        ]);

        $this->assignPermissions($areaMaster, [
            $manageRequests, $assignRequests, $verifyQuality, $viewRequests
        ]);

        $this->assignPermissions($technician, [
            $createRequests, $viewRequests
        ]);

        $this->assignPermissions($brigEngineer, [
            $manageRequests, $viewRequests
        ]);

        $this->assignPermissions($manager, [
            $viewAnalytics, $manageRequests, $viewRequests
        ]);

        $this->assignPermissions($supply, [
            $manageSupplies, $viewRequests
        ]);

        // Назначение роли администратора
        if ($adminUser = User::findOne(['username' => 'admin'])) {
            $auth->assign($admin, $adminUser->id);
        }

        echo "RBAC initialization completed.\n";
    }

    private function createPermission($name, $defect_short)
    {
        $auth = Yii::$app->authManager;
        $permission = $auth->getPermission($name);
        if (!$permission) {
            $permission = $auth->createPermission($name);
            $permission->defect_short = $defect_short;
            $auth->add($permission);
        }
        return $permission;
    }

    private function createRole($name, $defect_short, $title = null)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);
        if (!$role) {
            $role = $auth->createRole($name);
            $role->defect_short = $defect_short;
            if ($title) {
                $role->data = ['title' => $title];
            }
            $auth->add($role);
        }
        return $role;
    }

    private function assignPermissions($role, $permissions)
    {
        $auth = Yii::$app->authManager;
        foreach ($permissions as $permission) {
            if (!$auth->hasChild($role, $permission)) {
                $auth->addChild($role, $permission);
            }
        }
    }
}