<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use unclead\widgets\MultipleInput;

/* @var $this yii\web\View */
/* @var $model common\models\WidgetMenu */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="widget-menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo \common\models\Languages::showSelectButtons();
    ?>
    <hr/>
    <?php echo $form->errorSummary($model) ?>

    <?php echo $form->field($model, 'key')->textInput(['maxlength' => 1024]) ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => 512]) ?>

    <?php echo $form->field($model, 'items')->widget(MultipleInput::className(), [
        'columns' =>
            [
                [
                    'name' => 'id',
                    'type' => 'hiddenInput'
                ],
                [
                    'name' => 'active',
                    'type' => 'checkbox',
                    'headerOptions' => [
                        'width' => '20px',
                    ]
                ],
                [
                    'name' => 'name',
                    'title' => 'Пункт меню',
                    'value' => function ($data) {
                        return $data->name;
                    },
                    'options' => [
                        'class' => 'mlang',
                    ],
                ],
                [
                    'name' => 'url',
                    'title' => 'Ссылка',
                    'value' => function ($data) {
                        return $data->url;
                    },
                    'options' => [
                        'class' => 'mlang',
                    ],
                ],
                [
                    'name' => 'sort',
                    'title' => 'Сортировка',
                    'headerOptions' => [
                        'width' => '100px',
                    ],
                    'defaultValue' => '500'
                ],
            ]
    ])->label(false);
    ?>

    <?php echo $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Cancel'), ['index'], ['class' => 'btn btn-default']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], ['class' => $model->isNewRecord ? 'hidden' : 'btn btn-danger pull-right', "onclick" => "return confirm('".Yii::t('backend', 'Delete_confirm')."');"]) ?>
    </div>

    <?php ActiveForm::end(); ?>



</div>
