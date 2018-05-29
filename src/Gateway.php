<?php
/**
 * @link https://github.com/yiiviet/yii2-esms
 * @copyright Copyright (c) 2017 Yii Viet
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */


namespace yiiviet\esms;

use vxm\gatewayclients\RequestData;
use vxm\gatewayclients\BaseGateway;
use vxm\gatewayclients\DataInterface;

use vxm\gatewayclients\RequestEvent;
use yii\httpclient\Client as HttpClient;

/**
 * Lớp Gateway kế thừa và thực thi [[\\vxm\\gatewayclients\\BaseGateway]] cung cấp các phương thức hổ trợ giao tiếp với eSMS
 * như gửi sms/voice call, kiểm tra trạng thái, số dư. Hiện tại nó hổ trợ 100% tính năng từ eSMS API.
 *
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 */
class Gateway extends BaseGateway
{
    /**
     * Lệnh thực thi gửi sms.
     */
    const RC_SEND_SMS = 'sendSMS';

    /**
     * Lệnh thực thi gửi voice call.
     */
    const RC_SEND_VOICE = 'sendVoice';

    /**
     * Lệnh thực thi lấy số dư tài khoản của `client`.
     */
    const RC_GET_BALANCE = 'getBalance';

    /**
     * Lệnh thực thi kiểm tra trang thái sms/voice call (tổng quan bao nhiều người nhận, số tin đã gửi v..v).
     */
    const RC_GET_SEND_STATUS = 'getSendStatus';

    /**
     * Lệnh thực thi kiểm tra trang thái sms/voice call (chi tiết trên từng số điện thoại).
     */
    const RC_GET_RECEIVER_STATUS = 'getReceiverStatus';

    /**
     * API endpoint dùng để gửi sms.
     */
    const SEND_SMS_URL = 'SendMultipleMessage_V4_get';

    /**
     * Full API endpoint dùng để gửi voice call.
     */
    const SEND_VOICE_FULL_URL = 'http://voiceapi.esms.vn/MainService.svc/json/MakeCall';

    /**
     * API endpoint dùng để kiểm tra trang thái sms/voice call (tổng quan bao nhiều người nhận, số tin đã gửi v..v).
     */
    const GET_SEND_STATUS_URL = 'GetSendStatus';

    /**
     * API endpoint dùng để kiểm tra trạng thái sms/voice call (chi tiết trên từng số điện thoại).
     */
    const GET_RECEIVER_STATUS_URL = 'GetSmsReceiverStatus_get';

    /**
     * @event [[RequestEvent]] sự kiện diễn ra trước khi gửi sms.
     */
    const EVENT_BEFORE_SEND_SMS = 'beforeSendSMS';

    /**
     * @event [[RequestEvent]] sự kiện diễn ra sau khi gửi sms.
     */
    const EVENT_AFTER_SEND_SMS = 'afterSendSMS';

    /**
     * @event [[RequestEvent]] sự kiện diễn ra trước khi gửi voice call.
     */
    const EVENT_BEFORE_SEND_VOICE = 'beforeSendVoice';

    /**
     * @event [[RequestEvent]] sự kiện diễn ra sau khi gửi voice call.
     */
    const EVENT_AFTER_SEND_VOICE = 'afterSendVoice';

    /**
     * @event [[RequestEvent]] sự kiện diễn ra trước khi lấy thông tin số dư.
     */
    const EVENT_BEFORE_GET_BALANCE = 'beforeGetBalance';

    /**
     * @event [[RequestEvent]] sự kiện diễn ra sau khi lấy thông tin số dư.
     */
    const EVENT_AFTER_GET_BALANCE = 'afterGetBalance';

    /**
     * @event [[RequestEvent]] sự kiện diễn ra trước khi lấy trạng thái tổng quan.
     */
    const EVENT_BEFORE_GET_SEND_STATUS = 'beforeGetSendStatus';

    /**
     * @event [[RequestEvent]] sự kiện diễn ra sau khi lấy trạng thái tổng quan.
     */
    const EVENT_AFTER_GET_SEND_STATUS = 'afterGetSendStatus';

    /**
     * @event [[RequestEvent]] sự kiện diễn ra trước khi lấy trạng thái chi tiết.
     */
    const EVENT_BEFORE_GET_RECEIVER_STATUS = 'beforeGetReceiverStatus';

    /**
     * @event [[RequestEvent]] sự kiện diễn ra sau lấy trạng thái chi tiết.
     */
    const EVENT_AFTER_GET_RECEIVER_STATUS = 'afterGetReceiverStatus';


    /**
     * @inheritdoc
     */
    public $clientConfig = ['class' => Client::class];

    /**
     * @inheritdoc
     */
    public $requestDataConfig = ['class' => RequestData::class];

    /**
     * @inheritdoc
     */
    public $responseDataConfig = ['class' => ResponseData::class];

    /**
     * @inheritdoc
     */
    public function getBaseUrl(): string
    {
        return 'http://rest.esms.vn/MainService.svc/json';
    }

    /**
     * @inheritdoc
     */
    public function beforeRequest(RequestEvent $event)
    {
        switch ($event->requestData->getCommand()) {
            case self::RC_SEND_SMS:
                $this->trigger(self::EVENT_BEFORE_SEND_SMS);
                break;
            case self::RC_SEND_VOICE:
                $this->trigger(self::EVENT_BEFORE_SEND_VOICE);
                break;
            case self::RC_GET_BALANCE:
                $this->trigger(self::EVENT_BEFORE_GET_BALANCE);
                break;
            case self::RC_GET_SEND_STATUS:
                $this->trigger(self::EVENT_BEFORE_GET_SEND_STATUS);
                break;
            case self::RC_GET_RECEIVER_STATUS:
                $this->trigger(self::EVENT_BEFORE_GET_RECEIVER_STATUS);
                break;
            default:
                break;
        }

        parent::beforeRequest($event);
    }

    /**
     * @inheritdoc
     */
    public function afterRequest(RequestEvent $event)
    {
        switch ($event->requestData->getCommand()) {
            case self::RC_SEND_SMS:
                $this->trigger(self::EVENT_AFTER_SEND_SMS);
                break;
            case self::RC_SEND_VOICE:
                $this->trigger(self::EVENT_AFTER_SEND_VOICE);
                break;
            case self::RC_GET_BALANCE:
                $this->trigger(self::EVENT_AFTER_GET_BALANCE);
                break;
            case self::RC_GET_SEND_STATUS:
                $this->trigger(self::EVENT_AFTER_GET_SEND_STATUS);
                break;
            case self::RC_GET_RECEIVER_STATUS:
                $this->trigger(self::EVENT_AFTER_GET_RECEIVER_STATUS);
                break;
            default:
                break;
        }

        parent::afterRequest($event);
    }

    /**
     * Phương thức thực thi gửi sms.
     * Nó chính là phương thức ánh xạ của [[request()]] thực hiện lệnh [[RC_SEND_SMS]]
     *
     * @param array $data Mảng dữ liệu eSMS yêu cầu đề gửi sms.
     * @param null $clientId Client thực thi lệnh. Nếu không thiết lập giá trị của [[getDefaultClient()]] sẽ được sử dụng.
     * @return ResponseData|DataInterface Dữ liệu phản hồi từ eSMS.
     * @throws \ReflectionException|\yii\base\InvalidConfigException
     */
    public function sendSMS(array $data, $clientId = null): DataInterface
    {
        return $this->request(self::RC_SEND_SMS, $data, $clientId);
    }

    /**
     * Phương thức thực thi gửi voice call.
     * Nó chính là phương thức ánh xạ của [[request()]] thực hiện lệnh [[RC_SEND_VOICE]]
     *
     * @param array $data Mảng dữ liệu eSMS yêu cầu đề gửi voice call.
     * @param null $clientId Client thực thi lệnh. Nếu không thiết lập giá trị của [[getDefaultClient()]] sẽ được sử dụng.
     * @return ResponseData|DataInterface Dữ liệu phản hồi từ eSMS.
     * @throws \ReflectionException|\yii\base\InvalidConfigException
     */
    public function sendVoice(array $data, $clientId = null): DataInterface
    {
        return $this->request(self::RC_SEND_VOICE, $data, $clientId);
    }

    /**
     * Phương thức thực thi lấy số dư tài khoản `client`.
     * Nó chính là phương thức ánh xạ của [[request()]] thực hiện lệnh [[RC_GET_BALANCE]]
     *
     * @param array $data Mảng dữ liệu eSMS yêu cầu đề lấy số dư.
     * @param null $clientId Client thực thi lệnh. Nếu không thiết lập giá trị của [[getDefaultClient()]] sẽ được sử dụng.
     * @return ResponseData|DataInterface Dữ liệu phản hồi từ eSMS.
     * @throws \ReflectionException|\yii\base\InvalidConfigException
     */
    public function getBalance($clientId = null): DataInterface
    {
        return $this->request(self::RC_GET_BALANCE, [], $clientId);
    }

    /**
     * Phương thức thực thi kiểm tra tổng quan trạng thái nhận tin (sms/voice call).
     * Nó chính là phương thức ánh xạ của [[request()]] thực hiện lệnh [[RC_GET_SEND_STATUS]]
     *
     * @param array $data Mảng dữ liệu eSMS yêu cầu để thực hiện kiểm tra.
     * @param null $clientId Client thực thi lệnh. Nếu không thiết lập giá trị của [[getDefaultClient()]] sẽ được sử dụng.
     * @return ResponseData|DataInterface Dữ liệu phản hồi từ eSMS.
     * @throws \ReflectionException|\yii\base\InvalidConfigException
     */
    public function getSendStatus($refId, $clientId = null): DataInterface
    {
        $data = ['RefId' => $refId];

        return $this->request(self::RC_GET_SEND_STATUS, $data, $clientId);
    }

    /**
     * Phương thức thực thi kiểm tra chi tiết trạng thái đã nhận tin (sms/voice call) trên từng số điện thoại.
     * Nó chính là phương thức ánh xạ của [[request()]] thực hiện lệnh [[RC_GET_RECEIVER_STATUS]]
     *
     * @param array $data Mảng dữ liệu eSMS yêu cầu để thực hiện kiểm tra.
     * @param null $clientId Client thực thi lệnh. Nếu không thiết lập giá trị của [[getDefaultClient()]] sẽ được sử dụng.
     * @return ResponseData|DataInterface Dữ liệu phản hồi từ eSMS.
     * @throws \ReflectionException|\yii\base\InvalidConfigException
     */
    public function getReceiverStatus($refId, $clientId = null): DataInterface
    {
        $data = ['RefId' => $refId];

        return $this->request(self::RC_GET_RECEIVER_STATUS, $data, $clientId);
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    protected function requestInternal(RequestData $requestData, HttpClient $httpClient): array
    {
        /** @var Client $client */
        $client = $requestData->getClient();
        $command = $requestData->getCommand();
        $commandUrls = [
            self::RC_GET_BALANCE => "{$client->apiKey}/{$client->secretKey}",
            self::RC_GET_SEND_STATUS => self::GET_SEND_STATUS_URL,
            self::RC_GET_RECEIVER_STATUS => self::RC_GET_RECEIVER_STATUS,
            self::RC_SEND_SMS => self::SEND_SMS_URL,
            self::RC_SEND_VOICE => '',
        ];
        $url = $commandUrls[$command];
        $data = $requestData->get();
        $data[0] = $url;
        $baseUrl = $httpClient->baseUrl;

        if ($command === self::RC_SEND_VOICE) {
            $httpClient->baseUrl = self::SEND_VOICE_FULL_URL;
        }

        $responseData = $httpClient->get($url)->send()->getData();
        $httpClient->baseUrl = $baseUrl;

        return $responseData;
    }

}
