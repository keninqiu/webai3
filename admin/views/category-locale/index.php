<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Locale;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoryLocaleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Category Locales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-locale-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Category Locale', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'locale_id',
                'value' => 'locale.value',
                'filter' => Html::activeDropDownList($searchModel, 'locale_id', [''=>'']+ArrayHelper::map(Locale::find()->all(), 'id', 'value'), ['class' => 'form-control'])
            ],
            'name',
            'value',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
