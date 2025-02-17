<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use common\models\User;
use common\models\Request;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // Статистика
        $userCount = User::find()->count();
        $requestCount = Request::find()->count();
        $overdueCount = Request::find()->where(['<', 'deadline', time()])->count();
        $emergencyCount = Request::find()->where(['urgency' => 'Аварийная'])->count();
        $statusData = Request::find()
        ->select(['status', 'COUNT(*) as count'])
        ->groupBy('status')
        ->asArray()
        ->all();

        // Последние заявки
        $recentRequests = new ActiveDataProvider([
            'query' => Request::find()->orderBy('created_at DESC')->limit(5),
            'pagination' => false,
        ]);

        $statusLabels = json_encode(array_column($statusData, 'status'));
        $statusData = json_encode(array_column($statusData, 'count'));

        return $this->render('index', [
            'userCount' => $userCount,
            'requestCount' => $requestCount,
            'overdueCount' => $overdueCount,
            'emergencyCount' => $emergencyCount,
            'recentRequests' => $recentRequests, // Передаем переменную в представление
            'statusLabels' => $statusLabels, // Передаем переменную в представление
            'statusData' => $statusData,
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
