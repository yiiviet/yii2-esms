<?php
/**
 * @link https://github.com/yiiviet/yii2-esms
 * @copyright Copyright (c) 2017 Yii Viet
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yiiviet\tests\unit\esms;


/**
 * Lớp ESMSTest
 *
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 */
class ESMSTest extends TestCase
{

    public function testBalance()
    {
        $data = $this->eSMS->getBalance();

        if ($this->isConstantsTestDefined()) {
            $this->assertTrue($data->isOk);
            $this->assertGreaterThanOrEqual(0, $data['Balance']);
        } else {
            $this->assertFalse($data->isOk);
            $this->assertEquals(0, $data['Balance']);
        }
    }

    public function testSendSMS()
    {
        $data = $this->eSMS->sendSMS([
            'Phone' => '01648560484',
            'Content' => 'Hweeeeeeeeeeee'
        ]);

        if ($this->isConstantsTestDefined()) {
            $this->assertTrue($data->isOk);
        } else {
            $this->assertFalse($data->isOk);
        }
    }

    public function testGetSendStatus()
    {
        $data = $this->eSMS->getSendStatus('b4ce9ecf-d7e1-4878-ab16-5ed696de090312');

        if ($this->isConstantsTestDefined()) {
            $this->assertTrue($data->isOk);
        } else {
            $this->assertFalse($data->isOk);
        }
    }

    public function testGetReceiverStatus()
    {
        $data = $this->eSMS->getReceiverStatus('b4ce9ecf-d7e1-4878-ab16-5ed696de090312');

        if ($this->isConstantsTestDefined()) {
            $this->assertTrue($data->isOk);
        } else {
            $this->assertFalse($data->isOk);
        }
    }

    public function testSendVoiceCall()
    {
        $data = $this->eSMS->sendVoice([
            'Phone' => '0909113911',
            'ApiCode' => '96cd1977-dc4e-48d5-8ef9-cd4837840250',
            'PassCode' => '96cd1977-dc4e-48d5-8ef9-cd4837840250'
        ]);

        if ($this->isConstantsTestDefined()) {
            $this->assertTrue($data->isOk);
        } else {
            $this->assertFalse($data->isOk);
        }
    }

}
