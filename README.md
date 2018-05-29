# YII2 eSMS
**Yii2 Extension hổ trợ bạn tích hợp dịch vụ eSMS.**

[![Latest Stable Version](https://poser.pugx.org/yiiviet/yii2-esms/v/stable)](https://packagist.org/packages/yiiviet/yii2-esms)
[![Total Downloads](https://poser.pugx.org/yiiviet/yii2-esms/downloads)](https://packagist.org/packages/yiiviet/yii2-esms)
[![Build Status](https://travis-ci.org/yiiviet/yii2-esms.svg?branch=master)](https://travis-ci.org/yiiviet/yii2-esms)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yiiviet/yii2-esms/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yiiviet/yii2-esms/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/yiiviet/yii2-esms/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yiiviet/yii2-esms/?branch=master)
[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)

Nếu như bạn thường xuyên xây dựng hệ thống có liên quan đến `sms` hay `voice call` thì chắc hẳn
[eSMS](http://esms.vn) là một đối tác không quá xa lạ với bạn, extension này sẽ giúp bạn tích hợp dịch vụ của `eSMS`
vào hệ thống của bạn.

## Yêu cầu
* [PHP >= 7.1](http://php.net)
* [vxm/gateway-clients >= 1.0.9](https://github.com/vuongxuongminh/yii2-gateway-clients)

## Cài đặt

Cài đặt thông qua `composer` nếu như đó là một khái niệm mới với bạn xin click vào 
[đây](http://getcomposer.org/download/) để tìm hiểu nó.

```sh
composer require "yiiviet/yii2-esms"
```

hoặc thêm

```json
"yiiviet/yii2-esms": "*"
```

vào phần `require` trong file composer.json.

## Thiết lập

Sau khi cài đặt hoàn tất bạn hãy vào thư mục `config` mở file `web.php` và thêm cấu hình sau
vào `components`:

```php

'components' => [
    'eSMS' => [
        'class' => 'yiiviet\esms\Gateway',
        'client' => [
            'apiKey' => 'API key ban dang ky tai eSMS (phan quan ly api)',
            'secretKey' => 'Secret key ban dang ky tai eSMS (phan quan ly api)'
        ]
    ]
]

```

Sau khi thiết lập xong ngay lập tức bạn đã có thể giao tiếp với `eSMS` thông qua cú pháp sau:
`Yii::$app->eSMS`.

## Sử dụng cơ bản

**1. Cách gửi tin nhắn:**

```php
    $result = Yii::$app->eSMS->sendSMS([
        'Phone' => '0909113911',
        'Content' => 'Hi Mr.Minh'
    ]);
    
    if ($result->isOk) {
        Yii::info('Send sms to Mr.Minh success! SMSID: ' . $result->SMSID);
    } else {
        Yii::warning($result->message);
    }
```

**2. Cách gửi voice call (cuộc gọi thoại):**

```php
    Yii::$app->eSMS->sendVoice([
        'Phone' => '0909113911',
        'ApiCode' => 'xxxxxxxxxxx', // Liên hệ kỹ thuật eSMS cấp
        'ApiPass' => 'xxxxxxxxxxx'
    ]);
    
    if ($result->isOk) {
        Yii::info('Send voice call to Mr.Minh success! SMSID: ' . $result->SMSID);
    } else {
        Yii::warning($result->message);
    }    
```

**3. Cách kiểm tra số dư tài khoản:**

```php
    $result = Yii::$app->eSMS->getBalance();
    
    if ($result->isOk) {
        Yii::info('Balance of account: ' . $result->Balance);
    } else {
        Yii::warning($result->message);
    }
```

**4. Cách kiểm tra trạng thái tin nhắn đã gửi:**

```php
    $result = Yii::$app->eSMS->getSendStatus($SMSID);
    
    if ($result->isOk) {
        Yii::info('Sent: ' . $result->SentSuccess);
    } else {
        Yii::warning($result->message);
    }
```

* `$SMSID` có được trong kết quả gửi `sms` hoặc `voice call` vì thế sau khi gửi tin nhắn xong bạn nên lưu lại `$SMSID`.


**5. Cách kiểm tra trạng thái chi tiết tin nhắn đã gửi (hiển thị chi tiết từng số điện thoại):**

```php
    $result = Yii::$app->eSMS->getReceiverStatus($SMSID);
    
    if ($result->isOk) {
        Yii::info('Sent: ' . var_export($result->ReceiverList, true));
    } else {
        Yii::warning($result->message);
    }
```

* `$SMSID` có được trong kết quả gửi `sms` hoặc `voice call` vì thế sau khi gửi tin nhắn xong bạn nên lưu lại `$SMSID`.

## Sử dụng nâng cao

Nếu bạn muốn tìm hiểu sau hơn về các thành phần khi tạo lệnh gửi `sms` hoặc `voice call` hay các thành 
phần kết quả mà `eSMS` gửi về thì mời bạn kham khảo thêm tại tài liệu của `eSMS` tại [đây](https://account.esms.vn/TailieuAPI_V4_060215_Rest_Public.pdf).
Tên các thành phần trong tài liệu eSMS đồng nhất với tên các thành phần (property, element key) của extension này.
