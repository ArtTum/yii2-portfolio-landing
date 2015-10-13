<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Skills */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="skill-create-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php
    echo \common\models\Languages::showSelectButtons();
    ?>
    <hr/>
    <?php echo $form->field($model, 'title')->textInput(['maxlength' => 50, 'class' => 'form-control mlang']) ?>
    <?php echo $form->field($model, 'description')->textarea(['maxlength' => 1500, 'class' => 'mlang', 'id' => 'ckeditor']) ?>
    <?php echo $form->field($model, 'type')->dropDownList(['test'=>'test']) ?>
    <?php echo $form->field($model, 'active')->checkbox() ?>
    <?php echo $form->field($model, 'icon_name')->textInput() ?>
    <?php echo $form->field($model, 'mark')->textInput() ?>
    <?php echo $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?php echo $form->errorSummary($model) ?>
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
