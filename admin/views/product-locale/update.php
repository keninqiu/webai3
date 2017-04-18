<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductLocale */

$this->title = 'Update Product Locale: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Product Locales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-locale-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
