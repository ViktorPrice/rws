<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap4\Alert;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\comment;

/* @var $this yii\web\View */
/* @var $model common\models\Request */

$this->title = 'Заявка #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <?= Alert::widget([
            'options' => ['class' => 'alert-success'],
            'body' => Yii::$app->session->getFlash('success'),
        ]) ?>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'train_number',
            'carriage_number',
            'defect_short',
            'defect_full:ntext',
            [
                'attribute' => 'photo',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->photo ? Html::img('@web/' . $model->photo, ['class' => 'img-thumbnail', 'style' => 'max-width: 300px;']) : 'Фото отсутствует';
                },
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    $statusColors = [
                        'Создано' => 'lightcoral',
                        'Назначено' => 'yellow',
                        'В работе' => 'orange',
                        'На проверке' => 'lightblue',
                        'Требуется канава' => 'gray',
                        'Закрыто' => 'lightgreen',
                        'Донор' => 'blue',
                        'Ожидается поставка' => 'pink',
                    ];
                    return Html::tag('span', $model->status, [
                        'style' => 'background-color: ' . ($statusColors[$model->status] ?? 'white') . '; padding: 5px; border-radius: 5px;',
                    ]);
                },
                'format' => 'raw',
            ],
            'created_at:datetime',
            'deadline_at:datetime',
            [
                'attribute' => 'responsible_id',
                'value' => function ($model) {
                    return $model->responsible ? $model->responsible->username : 'Не назначен';
                },
            ],
            [
                'attribute' => 'qr_code',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->qr_code ? Html::img('@web/uploads/qr/' . $model->qr_code, ['class' => 'img-thumbnail', 'style' => 'max-width: 150px;']) : 'QR-код отсутствует';
                },
            ],
        ],
    ]) ?>

    <h3>История статусов</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Статус</th>
                <th>Дата изменения</th>
                <th>Комментарий</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($model->statusHistory as $history): ?>
                <tr>
                    <td><?= Html::encode($history->status) ?></td>
                    <td><?= Yii::$app->formatter->asDatetime($history->created_at) ?></td>
                    <td><?= Html::encode($history->comment) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Комментарии</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Автор</th>
                <th>Комментарий</th>
                <th>Дата</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($model->comments as $comment): ?>
                <tr>
                    <td><?= Html::encode($comment->author->username) ?></td>
                    <td><?= Html::encode($comment->text) ?></td>
                    <td><?= Yii::$app->formatter->asDatetime($comment->created_at) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Добавить комментарий</h3>
    <?php $form = ActiveForm::begin([
        'action' => Url::to(['comment/create', 'request_id' => $model->id]),
    ]); ?>

    <?= $form->field(new Comment(), 'text')->textarea(['rows' => 3])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <br>


    <div class="form-group">
        <?= Html::a('Распечатать акт', ['print', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить эту заявку?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

</div>