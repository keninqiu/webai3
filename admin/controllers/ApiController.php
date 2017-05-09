<?php
namespace app\controllers;

use yii\rest\ActiveController;
use Yii;
class ApiController extends ActiveController
{
    public $modelClass = 'app\models\Order';
}