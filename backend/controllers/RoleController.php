<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use backend\models\RoleForm;

class RoleController extends Controller
{
    public function actionIndex()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $roles,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($name)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);

        if ($role === null) {
            throw new \yii\web\NotFoundHttpException('Роль не найдена.');
        }

        return $this->render('view', [
            'model' => $role,
        ]);
    }

    public function actionCreate()
    {
        $model = new RoleForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($name)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);

        if ($role === null) {
            throw new \yii\web\NotFoundHttpException('Роль не найдена.');
        }

        $model = new RoleForm();
        $model->name = $role->name;
        $model->description = $role->description;

        if ($model->load(Yii::$app->request->post()) && $model->update($name)) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($name)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);
        $auth->remove($role);

        return $this->redirect(['index']);
    }
}