<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "polling_center".
 *
 * @property int $id
 * @property int|null $county_code
 * @property string|null $county_name
 * @property int|null $constituency_code
 * @property string|null $constituency_name
 * @property int|null $caw_code
 * @property  int|null $registration_center_code
 * @property string|null $registration_center_name
 * @property string|null $caw_name
 * @property int|null $voters_per_registration_center
 * @property string|null $polling_station_code
 * @property string|null $polling_station_name
 * @property int|null $voters_per_polling_station
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class PollingCenter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'polling_center';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['county_code', 'constituency_code', 'caw_code','registration_center_code', 'voters_per_registration_center', 'voters_per_polling_station', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['county_name'], 'string', 'max' => 30],
            [['constituency_name', 'registration_center_name', 'polling_station_name','polling_station_code'], 'string', 'max' => 150],
            [['caw_name'], 'string', 'max' => 255],
            ['polling_station_code','unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'county_code' => 'County Code',
            'county_name' => 'County Name',
            'constituency_code' => 'Constituency Code',
            'constituency_name' => 'Constituency Name',
            'caw_code' => 'Caw Code',
            'caw_name' => 'Caw Name',
            'registration_center_name' => 'Registration Center Name',
            'voters_per_registration_center' => 'Voters Per Registration Center',
            'polling_station_code' => 'Polling Station Code',
            'polling_station_name' => 'Polling Station Name',
            'voters_per_polling_station' => 'Voters Per Polling Station',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\queries\PollingCenterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\PollingCenterQuery(get_called_class());
    }
}
