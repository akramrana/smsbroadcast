<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ClientSmsTemplates;

/**
 * ClientSmsTemplateSearch represents the model behind the search form of `app\models\ClientSmsTemplates`.
 */
class ClientSmsTemplateSearch extends ClientSmsTemplates
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_sms_template_id', 'client_id', 'is_active', 'is_deleted'], 'integer'],
            [['title', 'template_text', 'created_at', 'updated_at'], 'safe'],
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
        $query = ClientSmsTemplates::find();

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
            'client_sms_template_id' => $this->client_sms_template_id,
            'client_id' => $this->client_id,
            'is_active' => $this->is_active,
            'is_deleted' => $this->is_deleted,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'template_text', $this->template_text]);

        return $dataProvider;
    }
}
