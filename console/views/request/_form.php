<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Request $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="request-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'train_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'carriage_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'node')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'defect_short')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'defect_full')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'urgency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'deadline_at')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'responsible_id')->textInput() ?>

    <?= $form->field($model, 'qr_code')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
