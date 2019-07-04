<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_subscriptions".
 *
 * @property int $client_subscription_id
 * @property int $client_id
 * @property double $amount
 * @property double $sms_charge
 * @property int $total_sms
 * @property string $created_at
 * @property string $payment_method
 * @property int $payment_status
 * @property string $comments
 *
 * @property Clients $client
 */
class ClientSubscriptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_subscriptions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'amount', 'sms_charge', 'total_sms', 'created_at', 'payment_method', 'payment_status'], 'required'],
            [['client_id', 'total_sms', 'payment_status'], 'integer'],
            [['amount', 'sms_charge'], 'number'],
            [['created_at'], 'safe'],
            [['comments'], 'string'],
            [['payment_method'], 'string', 'max' => 10],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'client_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'client_subscription_id' => 'Client Subscription ID',
            'client_id' => 'Client ID',
            'amount' => 'Amount',
            'sms_charge' => 'Sms Charge',
            'total_sms' => 'Total Sms',
            'created_at' => 'Created At',
            'payment_method' => 'Payment Method',
            'payment_status' => 'Payment Status',
            'comments' => 'Comments',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['client_id' => 'client_id']);
    }
}
