<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="project-create-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php
    echo \common\models\Languages::showSelectButtons();
    ?>
    <hr/>
    <?php echo $form->field($model, 'title')->textInput(['maxlength' => 50, 'class' => 'form-control mlang']) ?>
    <?php echo $form->field($model, 'description')->textarea(['maxlength' => 1500, 'class' => 'mlang', 'id' => 'ckeditor']) ?>
    <?php
    $projectTypes = \common\models\ProjectsType::getTypeLabels();
    if (sizeof($projectTypes) > 0) {
        echo $form->field($model, 'type_id')->dropDownList($projectTypes);
    } else
    {}

        ?>
    <?php echo $form->field($model, 'tools')->textInput() ?>
    <?php echo $form->field($model, 'site_url')->textInput() ?>
    <?php echo $form->field($model, 'case_url')->textInput(['class' => 'form-control mlang']) ?>
    <?php echo $form->field($model, 'sort')->textInput() ?>
    <?php echo $form->field($model, 'active')->checkbox() ?>


    <div class="form-group">
        <?php echo $form->errorSummary($model) ?>
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Cancel'), ['index'], ['class' => 'btn btn-default']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], ['class' => $model->isNewRecord ? 'hidden' : 'btn btn-danger pull-right', "onclick" => "return confirm('" . Yii::t('backend', 'Delete_confirm') . "');"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
