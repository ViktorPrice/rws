<?php
namespace console\controllers;

use yii\console\Controller;
use common\models\User;
use yii\helpers\Console;

class UserController extends Controller
{
    public function actionCreateAdmin($username, $email, $password)
    {
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;

        if ($user->save()) {
            // Назначение роли "Администратор" (ID=1)
            Yii::$app->db->createCommand()->insert('user_role', [
                'user_id' => $user->id,
                'role_id' => 1,
            ])->execute();

            Console::output("Администратор создан!");
        } else {
            Console::output("Ошибка: " . print_r($user->errors, true));
        }
    }

    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Назначение роли
            $auth = Yii::$app->authManager;
            $role = $auth->getRole(Yii::$app->request->post('role'));
            $auth->assign($role, $model->id);

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = User::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Обновление роли
            $auth = Yii::$app->authManager;
            $auth->revokeAll($model->id);
            $role = $auth->getRole(Yii::$app->request->post('role'));
            $auth->assign($role, $model->id);

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