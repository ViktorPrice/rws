<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'train_number')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'defect_short')->textInput(['maxlength' => 100]) ?>

<?= $form->field($model, 'status')->dropDownList(
    \common\models\Request::getStatusOptions(),
    [
        'prompt' => 'Выберите статус',
        'options' => [
            'Создано' => ['data-color' => '#FFB6C1'],
            'Назначено' => ['data-color' => '#FFFF00'],
            'В работе' => ['data-color' => '#FFA500'],
            'На проверке' => ['data-color' => '#87CEEB'],
            'Требуется канава' => ['data-color' => '#808080'],
            'Закрыто' => ['data-color' => '#90EE90'],
            'Донор' => ['data-color' => '#0000FF'],
            'Ожидается поставка' => ['data-color' => '#FFC0CB']
        ],
        'class' => 'form-control status-selector'
    ]
) ?>

<?= $form->field($model, 'responsible_id')->dropDownList(
    ArrayHelper::map(
        User::find()
            ->joinWith('roles')
            ->where(['role.name' => 'Мастер участка'])
            ->all(),
        'id', 
        'username'
    ),
    ['prompt' => 'Выберите ответственного']
) ?>

<!-- JavaScript для динамической подсветки -->
<?php
$js = <<<JS
$('.status-selector').on('change', function() {
    const color = $(this).find('option:selected').data('color');
    $(this).css('background-color', color);
}).trigger('change');
JS;
$this->registerJs($js);
?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>