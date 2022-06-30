<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "candidate".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $countable
 * @property string|null $candidate_code
 * @property int|null $result_level_id
 * @property string|null $constituency_code
 */
class Candidate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'candidate';
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
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'countable', 'result_level_id'], 'integer'],
            [['name'], 'string', 'max' => 250],
            [['candidate_code', 'constituency_code'], 'string', 'max' => 45],
            [['candidate_code', 'name'], 'required'],
            [['name', 'candidate_code'], 'unique'],
            [
                'constituency_code',
                'required',
                'when' => function ($model) {
                    return $model->result_level_id == 2;
                },
                'whenClient' => "function (attribute, value) { 
                    return $('#candidate-result_level_id').val() == '2'; 
                }"
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'countable' => 'Countable',
            'candidate_code' => 'Candidate Code',
            'result_level_id' => 'Result Level ',
            'constituency_code' => 'Constituency Code',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\CandidateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\CandidateQuery(get_called_class());
    }

    public function getStation()
    {
        return $this->hasOne(PollingCenter::class, ['constituency_code' => 'constituency_code'])->from(PollingCenter::tableName());
    }

    public function getLevel()
    {
        return $this->hasOne(ResultsLevel::class, ['id' => 'result_level_id']);
    }
}
