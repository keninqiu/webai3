<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Locale */

$this->title = 'Create Locale';
$this->params['breadcrumbs'][] = ['label' => 'Locales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="locale-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
