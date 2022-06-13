<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Subcounties;

/**
 * SubcountiesSearch represents the model behind the search form of `app\models\Subcounties`.
 */
class SubcountiesSearch extends Subcounties
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SubCountyID', 'CountyID', 'CreatedBy', 'Deleted'], 'integer'],
            [['SubCountyName', 'Notes', 'CreatedDate'], 'safe'],
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
        $query = Subcounties::find();

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
            'SubCountyID' => $this->SubCountyID,
            'CountyID' => $this->CountyID,
            'CreatedDate' => $this->CreatedDate,
            'CreatedBy' => $this->CreatedBy,
            'Deleted' => $this->Deleted,
        ]);

        $query->andFilterWhere(['like', 'SubCountyName', $this->SubCountyName])
            ->andFilterWhere(['like', 'Notes', $this->Notes]);

        return $dataProvider;
    }
}
