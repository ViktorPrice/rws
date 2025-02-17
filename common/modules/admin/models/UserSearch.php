<?php

namespace backend\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

class UserSearch extends Model
{
    public $roleName;

    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'email', 'roleName'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find()->alias('u');
        $query->joinWith(['userRoles ur']);
    
        // 1. Загружаем параметры
        $this->load($params);
    
        // 2. Валидируем
        if (!$this->validate()) {
            return new ActiveDataProvider(['query' => $query]);
        }
    
        // 3. Применяем фильтры
        $query->andFilterWhere([
            'u.id' => $this->id,
            'u.status' => $this->status,
            'u.created_at' => $this->created_at,
            'u.updated_at' => $this->updated_at,
        ]);
    
        $query->andFilterWhere(['like', 'u.username', $this->username])
              ->andFilterWhere(['like', 'u.email', $this->email]);
    
        if ($this->roleName) {
            $query->joinWith(['userRoles.role r']);
            $query->andFilterWhere(['r.name' => $this->roleName]);
        }
    
        // 4. Создаем DataProvider после фильтрации
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'username',
                    'email',
                    'status',
                    'created_at',
                    'roleName' => [
                        'asc' => ['r.name' => SORT_ASC],
                        'desc' => ['r.name' => SORT_DESC],
                    ]
                ],
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);
    
        return $dataProvider;
    }
}