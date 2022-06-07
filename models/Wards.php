<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wards".
 *
 * @property int $WardID
 * @property string|null $WardName
 * @property int|null $SubCountyID
 * @property string|null $Notes
 * @property string $CreatedDate
 * @property int|null $CreatedBy
 * @property int $Deleted
 */
class Wards extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wards';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SubCountyID', 'CreatedBy', 'Deleted'], 'integer'],
            [['Notes'], 'string'],
            [['CreatedDate'], 'safe'],
            [['WardName'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'WardID' => 'Ward ID',
            'WardName' => 'Ward Name',
            'SubCountyID' => 'Sub County ID',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }
}
