<?php
/**
 * @link https://github.com/yiiviet/yii2-esms
 * @copyright Copyright (c) 2017 Yii Viet
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */


namespace yiiviet\esms;

use vxm\gatewayclients\RequestData as BaseRequestData;

/**
 * Lớp RequestData dùng để tạo các đối tượng tổng hợp dữ liệu đã kiểm tra tính trọn vẹn,
 * dùng để gửi yêu cầu thực thi đến eSMS.
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
                Gateway::RC_SEND_VOICE, Gateway::RC_SEND_SMS, Gateway::RC_GET_SEND_STATUS, Gateway::RC_GET_RECEIVER_STATUS
            ]],
            [['Phone'], 'required', 'on' => [Gateway::RC_SEND_VOICE, Gateway::RC_SEND_SMS]],
            [['SmsType', 'Content'], 'required', 'on' => Gateway::RC_SEND_SMS],
            [['ApiCode', 'PassCode'], 'required', 'on' => Gateway::RC_SEND_VOICE],
            [['RefId'], 'required', 'on' => [Gateway::RC_GET_SEND_STATUS, Gateway::RC_GET_RECEIVER_STATUS]]
        ];
    }

    /**
     * @inheritdoc
     */
    public function ensureAttributes(array &$attributes)
    {
        $command = $this->getCommand();
        if ($command !== Gateway::RC_GET_BALANCE) {
            $attributes['ApiKey'] = $this->client->apiKey;
            $attributes['SecretKey'] = $this->client->secretKey;
        }

        if ($command === Gateway::RC_SEND_SMS) {
            $attributes['SmsType'] = $attributes['SmsType'] ?? 4;
            $attributes['IsUnicode'] = $attributes['IsUnicode'] ?? 1;
            $attributes['Sandbox'] = $attributes['IsUnicode'] ?? 0;

            if ($attributes['SmsType'] === 1 or $attributes['SmsType'] === 2) {
                $this->addRule(['Brandname'], 'required');
            }
        }

        parent::ensureAttributes($attributes);
    }
}
