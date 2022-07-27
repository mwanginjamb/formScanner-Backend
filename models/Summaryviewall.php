<?php

namespace app\models;

use app\modules\apiV1\resources\UserResource;
use Yii;

/**
 * This is the model class for table "summaryviewall".
 *
 * @property string|null $full_names
 * @property string $username
 * @property int $agent_id
 * @property string|null $phone_number
 * @property int|null $center_id
 * @property string|null $polling_station_name
 * @property string|null $polling_station_code
 * @property int $id
 */
class Summaryviewall extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public  $_summary;
    public static function tableName()
    {
        return 'summaryviewall';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone_number'], 'required'],
            [['agent_id', 'center_id', 'id'], 'integer'],
            [['full_names'], 'string', 'max' => 1024],
            [['username'], 'string', 'max' => 255],
            [['phone_number'], 'string', 'max' => 10],
            [['polling_station_name'], 'string', 'max' => 250],
            [['polling_station_code'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'full_names' => 'Full Names',
            'username' => 'Username',
            'agent_id' => 'Agent ID',
            'phone_number' => 'Phone Number',
            'center_id' => 'Center ID',
            'polling_station_name' => 'Polling Station Name',
            'polling_station_code' => 'Polling Station Code',
            'id' => 'ID',
        ];
    }

    public function fetch()
    {
        $model = parent::find()->where(['phone_number' =>  $this->phone_number])->one();
        if ($model) {
            $this->_summary = $model;
            return $this->_summary;
        }

        return $model;
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\SummaryviewallQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\SummaryviewallQuery(get_called_class());
    }
}
