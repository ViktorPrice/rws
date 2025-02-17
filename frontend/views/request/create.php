<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Request;

/** @var yii\web\View $this */
/** @var common\models\Request $model */
/** @var ActiveForm $form */
?>
<div class="request-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'train_number')->textInput() ?>
    <?= $form->field($model, 'carriage_number')->textInput() ?>
    <?= $form->field($model, 'node')->textInput() ?>
    <?= $form->field($model, 'defect_short')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'defect_full')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'photoFile')->fileInput() ?>
    <?= $form->field($model, 'urgency')->dropDownList([
        Request::URGENCY_EMERGENCY => 'Аварийная',
        Request::URGENCY_URGENT => 'Срочная',
        Request::URGENCY_PLANNED => 'Плановая',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>