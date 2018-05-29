<?php
/**
 * @link https://github.com/yiiviet/yii2-esms
 * @copyright Copyright (c) 2017 Yii Viet
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yiiviet\esms;

use vxm\gatewayclients\BaseClient;

/**
 * Lớp Client
 *
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 */
class Client extends BaseClient
{
    /**
     * @var string Api key do eSMS cấp khi đăng ký tài khoản.
     */
    public $apiKey;

    /**
     * @var string Secret key do eSMS cấp khi đăng ký tài khoản.
     */
    public $secretKey;

}
