<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- Подключение Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => 'Панель управления',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top'],
    ]);

    $menuItems = [];

    // Пункты меню для авторизованных пользователей
    if (!Yii::$app->user->isGuest) {
        $menuItems = [
            [
                'label' => 'Главная',
                'url' => ['/site/index']
            ],
            [
                'label' => 'Заявки',
                'url' => ['/request/index'],
                'visible' => Yii::$app->user->can('manageRequests')
            ],
            [
                'label' => 'Пользователи',
                'url' => ['/user/index'],
                'visible' => Yii::$app->user->can('manageUsers')
            ],
            [
                'label' => 'Роли',
                'url' => ['/role/index'],
                'visible' => Yii::$app->user->can('manageRoles')
            ],
            [
                'label' => 'Личный кабинет',
                'url' => ['/profile/index']
            ]
        ];
    }

    // Элементы правого меню (логин/выход)
    $rightMenuItems = Yii::$app->user->isGuest
        ? [['label' => 'Войти', 'url' => ['/site/login']]]
        : [
            [
                'label' => 'Выйти (' . Yii::$app->user->identity->username . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ]
        ];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto'],
        'items' => $menuItems,
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'],
        'items' => $rightMenuItems,
    ]);

    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => $this->params['breadcrumbs'] ?? [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-end"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>