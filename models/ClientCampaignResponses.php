<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_campaign_responses".
 *
 * @property int $client_campaign_response_id
 * @property int $client_campaign_id
 * @property int $message_id
 * @property int $status
 * @property string $status_text
 * @property int $error_code
 * @property string $error_text
 * @property int $sms_count
 * @property double $current_credit
 * @property string $created_at
 *
 * @property ClientCampaigns $clientCampaign
 */
class ClientCampaignResponses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_campaign_responses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_campaign_id', 'message_id', 'status', 'status_text', 'error_code', 'error_text', 'sms_count', 'current_credit', 'created_at'], 'required'],
            [['client_campaign_id', 'message_id', 'status', 'error_code', 'sms_count'], 'integer'],
            [['current_credit'], 'number'],
            [['created_at'], 'safe'],
            [['status_text'], 'string', 'max' => 128],
            [['error_text'], 'string', 'max' => 255],
            [['client_campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientCampaigns::className(), 'targetAttribute' => ['client_campaign_id' => 'client_campaign_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'client_campaign_response_id' => 'Client Campaign Response ID',
            'client_campaign_id' => 'Client Campaign ID',
            'message_id' => 'Message ID',
            'status' => 'Status',
            'status_text' => 'Status Text',
            'error_code' => 'Error Code',
            'error_text' => 'Error Text',
            'sms_count' => 'Sms Count',
            'current_credit' => 'Current Credit',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientCampaign()
    {
        return $this->hasOne(ClientCampaigns::className(), ['client_campaign_id' => 'client_campaign_id']);
    }
}
