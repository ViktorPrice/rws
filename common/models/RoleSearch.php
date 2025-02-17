<?php


namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Role;

class RoleSearch extends Role
{

    public function scenarios()
    {
        // Наследуем сценарии от родительской модели
        return parent::scenarios();
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Role::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}