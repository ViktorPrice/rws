<?php
namespace backend\modules\settings; // Правильный namespace

class Module extends \yii\base\Module 
{
    public $controllerNamespace = 'backend\modules\settings\controllers';
    
    public function init()
    {
        parent::init();
    }
}