<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Настройки системы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="settings-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'default_deadline_hours')->input('number') ?>
    
    <?= $form->field($model, 'max_reassignments')->input('number') ?>
    
    <?= $form->field($model, 'notification_channels')->checkboxList([
        'email' => 'Email уведомления',
        'push' => 'Push уведомления'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>