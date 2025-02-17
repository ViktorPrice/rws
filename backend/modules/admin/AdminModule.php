<?php

namespace backend\modules\admin;

use yii\base\Module;

/**
 * Модуль для управления пользователями и ролями.
 */
class AdminModule extends Module
{
    /**
     * @var string Пространство имен для контроллеров модуля.
     */
    public $controllerNamespace = 'backend\modules\admin\controllers';

    /**
     * Инициализация модуля.
     */
    public function init()
    {
        parent::init();

        // Настройки модуля
        $this->setAliases([
            '@admin' => __DIR__,
        ]);

        // Дополнительная конфигурация (если требуется)
        $this->configureModule();
    }

    /**
     * Настройка модуля.
     */
    protected function configureModule()
    {
        // Например, можно настроить компоненты или параметры модуля
        \Yii::configure($this, [
            'components' => [
                // Пример настройки компонента
                'userManager' => [
                    'class' => 'backend\modules\admin\components\UserManager',
                ],
            ],
        ]);
    }
}
