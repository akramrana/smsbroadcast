<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ClientCampaigns;

/**
 * ClientCampaignSearch represents the model behind the search form of `app\models\ClientCampaigns`.
 */
class ClientCampaignSearch extends ClientCampaigns
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_campaign_id', 'client_id', 'character_count'], 'integer'],
            [['campaign_name', 'from_number', 'message', 'created_at', 'campaign_type','client_group_id', 'sent_to_all'], 'safe'],
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
        $query = ClientCampaigns::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['client_campaign_id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'client_campaign_id' => $this->client_campaign_id,
            //'client_id' => $this->client_id,
            'client_group_id' => $this->client_group_id,
            'character_count' => $this->character_count,
            'created_at' => $this->created_at,
            'sent_to_all' => $this->sent_to_all,
            'is_deleted' => 0
        ]);

        $query->andFilterWhere(['like', 'campaign_name', $this->campaign_name])
            ->andFilterWhere(['like', 'from_number', $this->from_number])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'campaign_type', $this->campaign_type]);
        
        if (\Yii::$app->session['_smsbroadcastAuth'] == 1) {
            $query->andFilterWhere(['client_id' => $this->client_id]);
        }
        else if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
            $query->andWhere(['client_id' => Yii::$app->user->identity->client_id]);
        }

        return $dataProvider;
    }
}
