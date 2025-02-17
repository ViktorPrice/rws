<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Request */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'train_number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'defect_short')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'status')->dropDownList(
    \common\models\Request::getStatusOptions(),
    ['prompt' => 'Выберите статус']
) ?>
    <?= $form->field($model, 'urgency')->dropDownList([
    'Аварийная' => 'Аварийная',
    'Срочная' => 'Срочная',
    'Плановая' => 'Плановая',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>