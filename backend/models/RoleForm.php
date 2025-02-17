<?php

namespace backend\models;

use Yii;
use yii\base\Model;

class RoleForm extends Model
{
    public $name;
    public $description;

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string', 'max' => 64],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
        ];
    }

    public function save()
    {
        $auth = Yii::$app->authManager;
        $role = $auth->createRole($this->name);
        $role->description = $this->description;
        return $auth->add($role);
    }

    public function update($name)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);
        $role->name = $this->name;
        $role->description = $this->description;
        return $auth->update($name, $role);
    }
}