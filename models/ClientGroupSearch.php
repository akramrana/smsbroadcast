<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ClientGroups;

/**
 * ClientGroupSearch represents the model behind the search form of `app\models\ClientGroups`.
 */
class ClientGroupSearch extends ClientGroups
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_group_id', 'client_id', 'is_active', 'is_deleted'], 'integer'],
            [['group_name', 'created_at', 'updated_at'], 'safe'],
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
        $query = ClientGroups::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['client_group_id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'client_group_id' => $this->client_group_id,
            //'client_id' => $this->client_id,
            'is_active' => $this->is_active,
            'is_deleted' => 0,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'group_name', $this->group_name]);
        
        if (\Yii::$app->session['_smsbroadcastAuth'] == 1) {
            $query->andFilterWhere(['client_id' => $this->client_id]);
        }
        else if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
            $query->andWhere(['client_id' => Yii::$app->user->identity->client_id]);
        }

        return $dataProvider;
    }
}
