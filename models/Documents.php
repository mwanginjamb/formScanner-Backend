<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "documents".
 *
 * @property int $id
 * @property string|null $description
 * @property string|null $results
 * @property string|null $polling_station
 * @property string|null $local_file_path
 * @property string|null $sharepoint_path
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Documents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documents';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['results'], 'string'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string', 'max' => 150],
            [['polling_station'], 'string', 'max' => 50],
            [['local_file_path', 'sharepoint_path'], 'string', 'max' => 250],
            [['polling_station'], 'unique', 'message' => 'Votes for this center have already been tallied.'],
           // [['description','polling_station'], 'required'],
            //[['description'],'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'results' => 'Results',
            'polling_station' => 'Polling Station',
            'local_file_path' => 'Local File Path',
            'sharepoint_path' => 'Sharepoint Path',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\queries\DocumentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\DocumentsQuery(get_called_class());
    }
}
