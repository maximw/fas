<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use app\helpers\RbacHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'create_date')
            ->widget(DatePicker::className(),['clientOptions' => ['name' => 'Invoice[create_date]'], 'dateFormat' => 'php:Y-m-d']) ?>

    <?= $form->field($model, 'expiration_date')
            ->widget(DatePicker::className(),['clientOptions' => ['name' => 'Invoice[expiration_date]'], 'dateFormat' => 'php:Y-m-d']) ?>

    <?= $form->field($model, 'paid')->checkbox(['name' => 'Invoice[paid]']) ?>

    <?= $form->field($model, 'sum')->textInput(['name' => 'Invoice[sum]', 'maxlength' => true]) ?>

    <?= $form->field($model, 'details')->textarea(['name' => 'Invoice[details]', 'rows' => 6]) ?>

    <?= $form->field($model, 'comment')->textarea(['name' => 'Invoice[comment]', 'rows' => 6]) ?>

    <?= $form->field($uploadModel, 'files[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <?php
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $model->scans,
        ]);
    ?>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'=>
            [
                [
                    'header' => 'Filename',
                    'class' => 'yii\grid\DataColumn',
                    'content' => function($model, $key, $index, $column) {
                            return Html::a($model->filename, Url::to(['/scan/view', 'id' => $model->id]));
                        },
                ],
                [
                    'header' => 'Actions',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function ($url, $model, $key) {
                            if (RbacHelper::can(RbacHelper::PERMISSION_DELETE)) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['/scan/delete', 'id' => $model->id]), [
                                    'title' => 'Delete',
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete?'),
                                    'data-method' => 'post', 'data-pjax' => '0',
                                ]);
                            }
                            return '';
                        }
                    ]
                ],
            ],

    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
