<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "document_line".
 *
 * @property int $id
 * @property int|null $candidate_id
 * @property int|null $votes
 * @property int|null $polling_station_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class DocumentLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'document_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['candidate_id', 'votes', 'polling_station_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['candidate_id','polling_station_id'],'unique','targetAttribute' => ['candidate_id','polling_station_id'],'message' => 'The Votes for this candidate in that polling station have already been tallied.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'candidate_id' => 'Candidate ID',
            'votes' => 'Votes',
            'polling_station_id' => 'Polling Station ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class
        ];
    }

    public function getCandidate()
    {
        return $this->hasOne(Candidate::class,['id' => 'candidate_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\queries\DocumentLineQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\DocumentLineQuery(get_called_class());
    }
}
