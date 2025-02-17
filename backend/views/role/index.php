<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = 'Роли';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить роль', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'description',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="bi bi-eye"></i>', ['view', 'name' => $model->name], [
                            'title' => 'Просмотр',
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<i class="bi bi-pencil"></i>', ['update', 'name' => $model->name], [
                            'title' => 'Редактировать',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<i class="bi bi-trash"></i>', ['delete', 'name' => $model->name], [
                            'title' => 'Удалить',
                            'data' => [
                                'confirm' => 'Вы уверены, что хотите удалить эту роль?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>