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
            [['name'], 'required'],
            ['countable', 'integer'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 250],
            ['name', 'unique', 'message' => 'This candidate is already registered.'],
            ['candidate_code', 'string'],
            ['result_level_id', 'integer'],
            ['constituency_code', 'string']
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
            'candidate_code' => 'Candidate Code'
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\queries\CandidateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\CandidateQuery(get_called_class());
    }
}
