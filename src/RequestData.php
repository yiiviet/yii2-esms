<?php
/**
 * @link https://github.com/yiiviet/yii2-esms
 * @copyright Copyright (c) 2017 Yii Viet
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */


namespace yiiviet\esms;

use vxm\gatewayclients\RequestData as BaseRequestData;

/**
 * Lớp RequestData
 *
 * @property Client $client
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 */
class RequestData extends BaseRequestData
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ApiKey', 'SecretKey'], 'required', 'on' => [
                Gateway::RC_SEND_VOICE, Gateway::RC_SEND_SMS, Gateway::RC_GET_BALANCE,
                Gateway::RC_GET_SEND_STATUS, Gateway::RC_GET_RECEIVER_STATUS
            ]],
            [['Phone'], 'required', 'on' => [Gateway::RC_SEND_VOICE, Gateway::RC_SEND_SMS]],
            [['SmsType'], 'required', 'on' => Gateway::RC_SEND_SMS],
            [['ApiCode', 'PassCode'], 'required', 'on' => Gateway::RC_SEND_VOICE],
            [['RefId'], 'required', 'on' => [Gateway::RC_GET_SEND_STATUS, Gateway::RC_GET_RECEIVER_STATUS]]
        ];
    }

    /**
     * @inheritdoc
     */
    public function ensureAttributes(array &$attributes)
    {
        $attributes['ApiKey'] = $this->client->apiKey;
        $attributes['SecretKey'] = $this->client->secretKey;
        $attributes['SmsType'] = $attributes['SmsType'] ?? 7;
        $attributes['IsUnicode'] = $attributes['IsUnicode'] ?? 1;
        $attributes['Sandbox'] = $attributes['IsUnicode'] ?? 0;

        parent::ensureAttributes($attributes);
    }
}
