<?php



use common\models\RequestSearch;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заявки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'train_number',
        'defect_short',
        [
            'attribute' => 'status',
            'contentOptions' => function ($model) {
                // Полный массив цветов из ТЗ (раздел 9)
                $colors = [
                    'Создано' => '#FFB6C1',       // Светло-красный
                    'Назначено' => '#FFFF00',     // Жёлтый
                    'В работе' => '#FFA500',      // Оранжевый
                    'На проверке' => '#87CEEB',   // Голубой
                    'Требуется канава' => '#808080', // Серый
                    'Закрыто' => '#90EE90',       // Зелёный
                    'Донор' => '#0000FF',         // Синий
                    'Ожидается поставка' => '#FFC0CB' // Розовый
                ];
                return ['style' => 'background-color: ' . $colors[$model->status]];
            },
            'filter' => \common\models\Request::getStatusOptions() // Фильтр-выпадающий список
        ],
        'urgency',
        'created_at:datetime',
        [
            'attribute' => 'responsible_id',
            'label' => 'Ответственный',
            'value' => function ($model) {
                return $model->responsible ? $model->responsible->username : 'Не назначено';
            },
            'filter' => Html::activeTextInput($searchModel, 'responsible_username', ['class' => 'form-control']),
        ],
        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>      

<?= Html::a('Добавить заявку', ['create'], ['class' => 'btn btn-success']) ?>
</div>