<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(); ?>

<?= $form->field($model, 'username')->textInput() ?>
<?= $form->field($model, 'email')->input('email') ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'role_id')->dropDownList(
    $roles,
    ['prompt' => 'Выберите роль']
) ?>

<div class="form-group">
    <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
