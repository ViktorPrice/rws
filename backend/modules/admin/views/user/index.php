<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Role;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'username',
        'email:email',
        [
            'attribute' => 'role',
            'value' => 'role.name',
            'filter' => ArrayHelper::map(Role::find()->all(), 'id', 'name'),
        ],
        ['class' => 'yii\grid\ActionColumn'],
        [
            'attribute' => 'role',
            'value' => function ($model) {
                $roles = Yii::$app->authManager->getRolesByUser($model->id);
                return implode(', ', array_keys($roles));
            },
        ],
        ['class' => 'yii\grid\ActionColumn'],
    ],
    ]); ?>


</div>
