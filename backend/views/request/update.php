<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Request */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'train_number')->textInput() ?>
    <?= $form->field($model, 'carriage_number')->textInput() ?>
    <?= $form->field($model, 'defect_short')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'status')->dropDownList(
    \common\models\Request::getStatusOptions(),
    ['prompt' => 'Выберите статус']
) ?>
    <?= $form->field($model, 'created_at')->textInput() ?>
    <?= $form->field($model, 'deadline')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>