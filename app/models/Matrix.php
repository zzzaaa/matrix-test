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

    public static function batchInsertOrUpdate(array $values)
    {

        $sql = 'REPLACE INTO '. self::tableName(). ' (`row`, `col`, `value`) VALUES(:row, :col, :value)';
        $query = new Query();
        $command = $query->createCommand()->setSql($sql);

        foreach ($values as $value) {
            $command->bindValues($value)->execute();

        }
        return $sql;
    }


    public static function massDelete(array $values)
    {
        $query = new Query();
        $command = $query->createCommand()->delete(self::tableName(), '(`row`, `col`) IN (:del)');
        $deleteKeys = [];

        foreach ($values as $value) {
            if (isset($value['row'],$value['col'])) {
                $deleteKeys[] = [$value['row'], $value['col']];
            }
        }

        $deleteKeys && $command->bindValue(':del', $deleteKeys);
    }


    public static function getMatrixAsArray()
    {
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
