<?php
/**
 * @link https://github.com/yiiviet/yii2-esms
 * @copyright Copyright (c) 2017 Yii Viet
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */


namespace yiiviet\tests\unit\esms;

/**
 * Lớp ESMSMissingParamTest
 *
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 */
class ESMSMissingParamTest extends TestCase
{

    /**
     * @expectedException \yii\base\InvalidConfigException
     */
    public function testSendSMS()
    {
        $this->eSMS->sendSMS([
            'Content' => 'Hweeeeeeeeeeee'
        ]);
    }

    /**
     * @expectedException \yii\base\InvalidConfigException
     */
    public function testSendVoiceCall()
    {
        $this->eSMS->sendVoice([
            'ApiCode' => '96cd1977-dc4e-48d5-8ef9-cd4837840250',
            'PassCode' => '96cd1977-dc4e-48d5-8ef9-cd4837840250'
        ]);
    }

}
