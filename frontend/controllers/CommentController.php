<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Comment;

class CommentController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['@'], // Только авторизованные пользователи
                    ],
                ],
            ],
        ];
    }

    public function actionCreate($request_id)
    {
        $model = new Comment();
        $model->request_id = $request_id;
        $model->author_id = Yii::$app->user->id; // Автор — текущий пользователь
        $model->created_at = time();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Комментарий добавлен!');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при сохранении комментария.');
            }
            return $this->redirect(['request/view', 'id' => $request_id]);
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }
}