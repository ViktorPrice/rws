<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use yii\data\ActiveDataProvider;
use common\models\UserSearch;

class UserController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        $model = User::findOne($id);
        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('Пользователь не найден.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new User(['scenario' => 'create']);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Назначение роли
            $model->setRole(Yii::$app->request->post('User')['role']);

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = User::findOne($id);
        $model->scenario = 'update';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Обновление роли
            $model->setRole(Yii::$app->request->post('User')['role']);

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = User::findOne($id);
        $auth = Yii::$app->authManager;
        $auth->revokeAll($model->id);
        $model->delete();

        return $this->redirect(['index']);
    }
}