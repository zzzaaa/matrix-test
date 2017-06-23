<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "matrix".
 *
 * @property integer $col
 * @property integer $row
 * @property integer $value
 */
class Matrix extends \yii\db\ActiveRecord
{
    const MATRIX_SIZE = 100;
    /**
     * @inheritdoc
     */

    public static function updateMatrix(array $matrixCells)
    {

        //запрос на вствку замену
        $replaceSql = 'REPLACE INTO '. self::tableName(). ' (`row`, `col`, `value`) VALUES(:row, :col, :value) ';
        $replaceCommand = (new Query)->createCommand()->setSql($replaceSql);

        //запрос удаления
        $deleteCommand = (new Query())->createCommand()->delete(self::tableName(), '(`row`, `col`) = (:row, :col)');

        //подготовка запросов
        $replaceCommand->prepare();
        $deleteCommand->prepare();

        $validateModel = new self();
        $errors = [];

        foreach ($matrixCells as $cell) {
            $validateModel->setAttributes($cell);
            //валидируем прешедшин данные
            if (!$validateModel->validate()) {
                $errors[] = array_merge($cell, ['error' => $validateModel->getErrors()]);
                continue;
            }

            //если есть значение, то обновляем
            if ($cell['value']) {
                //передаються только данные тк запрос подготовлеен
                $replaceCommand->pdoStatement->execute($cell);
            }
            else {
                unset($cell['value']);
                //передаються только данные тк запрос подготовлеен
                $deleteCommand->pdoStatement->execute($cell);
            }

        }

        return $errors;
    }



    public static function getMatrixAsArray()
    {

        //Не используем модели тк так быстрее и меньше конвертаций
        $query = new Query();
        return $query->from(self::tableName())->all();
    }

    public static function tableName()
    {
        return 'matrix';
    }

    public static function primaryKey()
    {
        return ['row', 'col'];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['col', 'row'], 'required'],
            [['col', 'row'], 'integer', 'min' => 0, 'max' => 100],
            [['value'], 'integer', 'min' => 0, 'max' => 999999],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'col' => 'Col',
            'row' => 'Row',
            'value' => 'Value',
        ];
    }

}
