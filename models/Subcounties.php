<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subcounties".
 *
 * @property int $SubCountyID
 * @property string|null $SubCountyName
 * @property int|null $CountyID
 * @property string|null $Notes
 * @property string $CreatedDate
 * @property int|null $CreatedBy
 * @property int $Deleted
 */
class Subcounties extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subcounties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CountyID', 'CreatedBy', 'Deleted'], 'integer'],
            [['Notes'], 'string'],
            [['CreatedDate'], 'safe'],
            [['SubCountyName'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SubCountyID' => 'Sub County ID',
            'SubCountyName' => 'Sub County Name',
            'CountyID' => 'County ID',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
