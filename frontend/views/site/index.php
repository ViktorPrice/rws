<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Управление заявками';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Добро пожаловать!</h1>
        
        <?php if (Yii::$app->user->isGuest): ?>
            <p class="lead">Для работы с системой требуется авторизация</p>
            <?= Html::a('Войти', ['/site/login'], ['class' => 'btn btn-lg btn-success']) ?>
            <?= Html::a('Регистрация', ['/site/signup'], ['class' => 'btn btn-lg btn-primary']) ?>
        <?php else: ?>
            <p class="lead">Вы вошли как: <?= Yii::$app->user->identity->username ?></p>
            <?= Html::a('Мои заявки', ['/request/index'], ['class' => 'btn btn-lg btn-info']) ?>
        <?php endif; ?>
    </div>
</div>
