<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PollingCenter;

/**
 * PollingCenterSearch represents the model behind the search form of `app\models\PollingCenter`.
 */
class PollingCenterSearch extends PollingCenter
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'county_code', 'constituency_code', 'caw_code', 'voters_per_registration_center', 'polling_station_code', 'voters_per_polling_station', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['county_name', 'constituency_name', 'caw_name', 'registration_center_name', 'polling_station_name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PollingCenter::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'county_code' => $this->county_code,
            'constituency_code' => $this->constituency_code,
            'caw_code' => $this->caw_code,
            'voters_per_registration_center' => $this->voters_per_registration_center,
            'polling_station_code' => $this->polling_station_code,
            'voters_per_polling_station' => $this->voters_per_polling_station,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'county_name', $this->county_name])
            ->andFilterWhere(['like', 'constituency_name', $this->constituency_name])
            ->andFilterWhere(['like', 'caw_name', $this->caw_name])
            ->andFilterWhere(['like', 'registration_center_name', $this->registration_center_name])
            ->andFilterWhere(['like', 'polling_station_name', $this->polling_station_name]);

        return $dataProvider;
    }
}
