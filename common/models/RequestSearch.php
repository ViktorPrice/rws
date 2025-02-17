<?php

namespace common\models;

use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class RequestSearch extends Request
{

    public $responsible_username;

    public function rules()
    {
        return [
            [['id', 'created_at', 'deadline', 'responsible_id'], 'integer'],
            [['train_number', 'carriage_number', 'node', 'defect_short', 'defect_full', 'photo', 'urgency', 'status', 'qr_code'], 'safe'],
            [['responsible_id'], 'integer'],
            [['responsible_username'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Request::find()->joinWith(['responsible']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'deadline' => $this->deadline,
            'responsible_id' => $this->responsible_id,
        ]);

        $query->andFilterWhere(['like', 'train_number', $this->train_number])
            ->andFilterWhere(['like', 'carriage_number', $this->carriage_number])
            ->andFilterWhere(['like', 'node', $this->node])
            ->andFilterWhere(['like', 'defect_short', $this->defect_short])
            ->andFilterWhere(['like', 'defect_full', $this->defect_full])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'urgency', $this->urgency])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'qr_code', $this->qr_code])
            ->andFilterWhere(['like', 'user.username', $this->responsible_username])
            ->andFilterWhere(['id' => $this->id, 'responsible_id' => $this->responsible_id]);

        return $dataProvider;
    }
}