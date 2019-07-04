<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ClientSubscriptions;

/**
 * ClientSubscriptionSearch represents the model behind the search form of `app\models\ClientSubscriptions`.
 */
class ClientSubscriptionSearch extends ClientSubscriptions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_subscription_id', 'client_id', 'total_sms', 'payment_status'], 'integer'],
            [['amount', 'sms_charge'], 'number'],
            [['created_at', 'payment_method', 'comments'], 'safe'],
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
        $query = ClientSubscriptions::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['client_subscription_id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'client_subscription_id' => $this->client_subscription_id,
            'client_id' => $this->client_id,
            'amount' => $this->amount,
            'sms_charge' => $this->sms_charge,
            'total_sms' => $this->total_sms,
            'created_at' => $this->created_at,
            'payment_status' => $this->payment_status,
            'is_deleted' => 0,
        ]);

        $query->andFilterWhere(['like', 'payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'comments', $this->comments]);

        return $dataProvider;
    }
}
