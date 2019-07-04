<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_sms_templates".
 *
 * @property int $client_sms_template_id
 * @property int $client_id
 * @property string $title
 * @property string $template_text
 * @property int $is_active
 * @property int $is_deleted
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Clients $client
 */
class ClientSmsTemplates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_sms_templates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'title', 'template_text', 'is_active', 'is_deleted', 'created_at', 'updated_at'], 'required'],
            [['client_id', 'is_active', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 32],
            [['template_text'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'client_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'client_sms_template_id' => 'Client Sms Template ID',
            'client_id' => 'Client ID',
            'title' => 'Title',
            'template_text' => 'Template Text',
            'is_active' => 'Is Active',
            'is_deleted' => 'Is Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
