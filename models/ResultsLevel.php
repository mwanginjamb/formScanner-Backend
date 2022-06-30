<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "results_level".
 *
 * @property int $id
 * @property int|null $level
 * @property string|null $description
 */
class ResultsLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */



    public static function tableName()
    {
        return 'results_level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level'], 'integer'],
            [['description'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => 'Level',
            'description' => 'Description',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ResultsLevelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ResultsLevelQuery(get_called_class());
    }
}
