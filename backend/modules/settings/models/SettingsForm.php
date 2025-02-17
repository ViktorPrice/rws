<?php

namespace backend\modules\settings\models;
use yii\base\Model;
use common\models\Settings;

class SettingsForm extends Model
{
    public $default_deadline_hours;
    public $max_reassignments;
    public $notification_channels;

    public function rules()
    {
        return [
            [['default_deadline_hours', 'max_reassignments'], 'integer', 'min' => 1],
            ['notification_channels', 'each', 'rule' => ['in', 'range' => ['email', 'push']],
        ],];
    }

    public function init()
    {
        parent::init();
        
        // Загрузка текущих значений
        $this->default_deadline_hours = Settings::getValue('default_deadline_hours');
        $this->max_reassignments = Settings::getValue('max_reassignments');
        $this->notification_channels = explode(',', Settings::getValue('notification_channels'));
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        Settings::updateSetting('default_deadline_hours', $this->default_deadline_hours);
        Settings::updateSetting('max_reassignments', $this->max_reassignments);
        Settings::updateSetting('notification_channels', implode(',', $this->notification_channels));

        return true;
    }
}