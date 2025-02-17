<?php

namespace frontend\controllers;

use Yii; // Импортируем класс Yii
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\Request;
use common\models\RequestSearch;

class RequestController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new RequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        // Проверка авторизации
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }
    
        $model = new Request();
        $transaction = Yii::$app->db->beginTransaction();
    
        try {
            if ($model->load(Yii::$app->request->post())) {
                // Устанавливаем системные поля ДО валидации
                $model->user_id = Yii::$app->user->id;
                $model->created_at = time();
                $model->deadline = time() + 12 * 60 * 60;
                
                // Загрузка файла
                $model->photoFile = UploadedFile::getInstance($model, 'photoFile');
                
                // Создаем папку uploads, если её нет
                $uploadPath = Yii::getAlias('@frontend/web/uploads');
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
    
                // Валидация
                if ($model->validate()) {
                    // Сохранение файла
                    if ($model->photoFile && !$model->upload()) {
                        throw new \Exception('Ошибка загрузки файла');
                    }
    
                    // Сохраняем модель
                    if (!$model->save(false)) {
                        throw new \Exception('Ошибка сохранения заявки');
                    }
    
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Заявка создана!');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::error('Ошибки валидации: ' . print_r($model->errors, true));
                    throw new \Exception('Ошибка валидации данных');
                }
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', $e->getMessage());
            Yii::error($e->getMessage());
        }
    
        return $this->render('create', [
            'model' => $model,
        ]);
    }
	
	
	

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->photoFile = UploadedFile::getInstance($model, 'photoFile');
            if ($model->upload() && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Request::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Заявка не найдена.');
    }
}