<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\helpers\RbacHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="invoice-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (RbacHelper::can(RbacHelper::PERMISSION_UPDATE)):?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
        
        <?php if (RbacHelper::can(RbacHelper::PERMISSION_DELETE)):?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'create_date',
            'expiration_date',
            'paid',
            'sum',
            'details:ntext',
            'comment:ntext',
        ],
    ]) ?>

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
            ],

    ]) ?>
</div>
