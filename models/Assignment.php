<?php

namespace app\models;

use app\modules\apiV1\resources\UserResource;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "agent_centers".
 *
 * @property int $id
 * @property int|null $agent_id
 * @property int|null $center_id 
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class Assignment extends \yii\db\ActiveRecord
{

    public $county;
    public $constituency;
    public $ward;
    public $center;

    const SCENARIOCREATE = 'scenariocreate';
    const SCENARIOUPDATE = 'scenarioupdate';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agent_centers';
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
            [['agent_id', 'center_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'result_level_id'], 'integer'],
            [['agent_id', 'center_id'], 'required'],
            // [['agent_id', 'center_id',], 'unique'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'agent_id' => 'Agent ID',
            'center_id' => 'Polling Station',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'result_level_id' => 'Results Level'
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\AgentCentersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\AgentCentersQuery(get_called_class());
    }

    public function getUser()
    {
        return $this->hasOne(UserResource::class, ['id' => 'agent_id']);
    }

    public function getCenter()
    {
        return $this->hasOne(PollingCenter::class, ['id' => 'center_id'])->from(PollingCenter::tableName());
    }

    public function getLevel()
    {
        return $this->hasOne(ResultsLevel::class, ['level' => 'result_level_id']);
    }
}
