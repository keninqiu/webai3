<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CategoryLocale */

$this->title = 'Create Category Locale';
$this->params['breadcrumbs'][] = ['label' => 'Category Locales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-locale-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
