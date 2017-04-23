<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Mode */

$this->title = Yii::t('app', 'Create Mode');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Modes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mode-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
