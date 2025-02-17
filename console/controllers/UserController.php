
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
}