<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ClientNumbers;

/**
 * ClientNumberSearch represents the model behind the search form of `app\models\ClientNumbers`.
 */
class ClientNumberSearch extends ClientNumbers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_number_id', 'client_id'], 'integer'],
            [['name', 'number', 'created_at'], 'safe'],
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
        $query = ClientNumbers::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['client_number_id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'client_number_id' => $this->client_number_id,
            //'client_id' => $this->client_id,
            'created_at' => $this->created_at,
            'is_deleted' => 0
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'number', $this->number]);
        
        if (\Yii::$app->session['_smsbroadcastAuth'] == 1) {
            $query->andFilterWhere(['client_id' => $this->client_id]);
        }
        else if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
            $query->andWhere(['client_id' => Yii::$app->user->identity->client_id]);
        }

        return $dataProvider;
    }
}
