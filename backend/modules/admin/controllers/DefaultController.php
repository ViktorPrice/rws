<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use common\models\Request;
use common\models\User;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        // Статистика
        $userCount = User::find()->count();
        $requestCount = Request::find()->count();
        $overdueCount = Request::find()->where(['<', 'deadline', time()])->count();
        $emergencyCount = Request::find()->where(['urgency' => 'Аварийная'])->count();

        // Последние заявки
        $recentRequests = new \yii\data\ActiveDataProvider([
            'query' => Request::find()->orderBy('created_at DESC')->limit(5),
            'pagination' => false,
        ]);

        // Статистика по статусам
        $statusData = Request::find()
            ->select(['status', 'COUNT(*) as count'])
            ->groupBy('status')
            ->asArray()
            ->all();
        $statusLabels = json_encode(array_column($statusData, 'status'));
        $statusData = json_encode(array_column($statusData, 'count'));

        return $this->render('index', [
            'userCount' => $userCount,
            'requestCount' => $requestCount,
            'overdueCount' => $overdueCount,
            'emergencyCount' => $emergencyCount,
            'recentRequests' => $recentRequests,
            'statusLabels' => $statusLabels,
            'statusData' => $statusData,
        ]);
    }
}