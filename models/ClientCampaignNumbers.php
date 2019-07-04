<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_campaign_numbers".
 *
 * @property int $client_campaign_number_id
 * @property int $client_campaign_id
 * @property int $client_number_id
 *
 * @property ClientNumbers $clientNumber
 * @property ClientCampaigns $clientCampaign
 */
class ClientCampaignNumbers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_campaign_numbers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_campaign_id', 'client_number_id'], 'required'],
            [['client_campaign_id', 'client_number_id'], 'integer'],
            [['client_number_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientNumbers::className(), 'targetAttribute' => ['client_number_id' => 'client_number_id']],
            [['client_campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientCampaigns::className(), 'targetAttribute' => ['client_campaign_id' => 'client_campaign_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'client_campaign_number_id' => 'Client Campaign Number ID',
            'client_campaign_id' => 'Client Campaign ID',
            'client_number_id' => 'Client Number ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientNumber()
    {
        return $this->hasOne(ClientNumbers::className(), ['client_number_id' => 'client_number_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientCampaign()
    {
        return $this->hasOne(ClientCampaigns::className(), ['client_campaign_id' => 'client_campaign_id']);
    }
}
