<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use app\helpers\RbacHelper;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'name' => 'newPassword', 'value'=>'']) ?>

    <?= $form->field($model, 'role')->dropDownList(RbacHelper::ROLES_DROPDOWN_LIST) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
