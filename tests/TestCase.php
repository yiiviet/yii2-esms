<?php
/**
 * @link https://github.com/yiiviet/yii2-esms
 * @copyright Copyright (c) 2017 Yii Viet
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */


namespace yiiviet\tests\unit\esms;

use Yii;

use yiiviet\esms\Gateway;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{

    /**
     * @var Gateway
     */
    protected $eSMS;

    public function setUp()
    {
        $this->eSMS = Yii::createObject([
            'class' => Gateway::class,
            'client' => [
                'apiKey' => $this->isConstantsTestDefined() ? API_KEY_TEST : 'XXXXXX',
                'secretKey' => $this->isConstantsTestDefined() ? SECRET_KEY_TEST : 'XXXXXX'
            ]
        ]);
    }

    public function tearDown()
    {
        $this->eSMS = null;
    }


    protected function isConstantsTestDefined()
    {
        return defined('API_KEY_TEST') && defined('SECRET_KEY_TEST');
    }

}
