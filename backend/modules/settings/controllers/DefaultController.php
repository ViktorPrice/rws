<?php


namespace backend\modules\settings\controllers;  // Правильный namespace

use Yii;
use yii\web\Controller;
use backend\modules\settings\models\SettingsForm;

class DefaultController extends Controller
{
 
	
public function actionIndex()
{
    // Создаем экземпляр модели
    $model = new \backend\modules\settings\models\SettingsForm(); 

    // Передаем переменную $model в представление
    return $this->render('index', [
        'model' => $model, // Важно: ключ 'model' соответствует переменной $model в представлении
    ]);
}
	
	
	public function actionCreate()
{
    $model = new MyModel(); // Создаем экземпляр модели

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => $model->id]);
    }

    // Передаем модель в представление
    return $this->render('create', [
        'model' => $model, // <-- Важно!
    ]);
}
}
