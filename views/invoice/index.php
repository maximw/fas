<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\helpers\RbacHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoices';
$this->params['breadcrumbs'][] = $this->title;

$buttonsTemplate = '';
if (RbacHelper::can(RbacHelper::PERMISSION_VIEW)) {
    $buttonsTemplate .= '{view} ';
}
if (RbacHelper::can(RbacHelper::PERMISSION_UPDATE)) {
    $buttonsTemplate .= '{update} ';
}
if (RbacHelper::can(RbacHelper::PERMISSION_DELETE)) {
    $buttonsTemplate .= '{delete} ';
}

?>
<div class="invoice-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (RbacHelper::can(RbacHelper::PERMISSION_CREATE)):?>
            <?= Html::a('Create Invoice', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'create_date',
            'expiration_date',
            'sum',
            'paid',

            ['class' => 'yii\grid\ActionColumn', 'template' => $buttonsTemplate],
        ],
    ]); ?>


</div>
