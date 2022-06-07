<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "counties".
 *
 * @property int $CountyID
 * @property string $CountyName
 * @property string|null $Notes
 * @property int $Active
 * @property int|null $RegionID
 * @property string|null $CreatedDate
 * @property int|null $CreatedBy
 */
class Counties extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'counties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CountyName'], 'required'],
            [['Notes'], 'string'],
            [['Active', 'RegionID', 'CreatedBy'], 'integer'],
            [['CreatedDate'], 'safe'],
            [['CountyName'], 'string', 'max' => 45],
            [['CountyName'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CountyID' => 'County ID',
            'CountyName' => 'County Name',
            'Notes' => 'Notes',
            'Active' => 'Active',
            'RegionID' => 'Region ID',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
        ];
    }
}
