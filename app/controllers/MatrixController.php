<?php


namespace app\controllers;

use app\models\Matrix;
use yii\rest\Controller;

class MatrixController extends Controller
{

    const CACHE_KEY = 'matrix';
    public function actions()
    {
        return parent::actions(); // TODO: Change the autogenerated stub
    }

    public function actionIndex()
    {
        //кешируем резултат
        $result = \Yii::$app->getCache()->getOrSet(self::CACHE_KEY, function(){
            return Matrix::getMatrixAsArray();
        }, 30 * 60);

        return $result;
    }

    public function actionUpdate()
    {
        $updateRecords =  \Yii::$app->getRequest()->getBodyParams();

        //если запрос что-то обновляет, то сбросим кеш
        if ($updateRecords) {
            \Yii::$app->getCache()->delete(self::CACHE_KEY);
        }
        $errors = Matrix::updateMatrix($updateRecords);

        return $errors;
    }

}