<?php
/**
 * @link https://github.com/yiiviet/yii2-esms
 * @copyright Copyright (c) 2017 Yii Viet
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */


namespace yiiviet\esms;

use vxm\gatewayclients\ResponseData as BaseResponseData;

/**
 * Lớp ResponseData dùng để tạo các đối tượng chứa dữ liệu nhận được từ eSMS.
 *
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 */
class ResponseData extends BaseResponseData
{

    /**
     * @var array Danh sách chi tiết thông tin của các mã code từ eSMS.
     */
    public static $responseCodes = [
        100 => 'Request thành công',
        99 => 'Lỗi không xác định, thử lại sau',
        101 => 'Đăng nhập thất bại (api key hoặc secrect key không đúng)',
        102 => 'Tài khoản đã bị khóa',
        103 => 'Số dư tài khoản không đủ dể gửi tin',
        104 => 'Mã Brandname không đúng',
        105 => 'Id tin nhắn không tồn tại',
        118 => 'Loại tin nhắn không hợp lệ',
        119 => 'Brandname quảng cáo phải gửi ít nhất 20 số điện thoại',
        131 => 'Tin nhắn brandname quảng cáo độ dài tối đa 422 kí tự',
        132 => 'Không có quyền gửi tin nhắn đầu số cố định 8755'
    ];

    /**
     * @inheritdoc
     */
    public function getIsOk(): bool
    {
        return (bool)$this->getCode();
    }

    /**
     * Phương thức hổ trợ lấy mã code gửi từ eSMS.
     *
     * @return int|null Trả về mã code nếu nó có tồn tại hoặc null nếu không.
     */
    public function getCode(): ?int
    {
        if (isset($this['CodeResponse'])) {
            return (int)$this['CodeResponse'];
        } elseif (isset($this['CodeResult'])) {
            return (int)$this['CodeResult'];
        } else {
            return null;
        }
    }

    /**
     * Phương thức lấy thông tin message từ mã code.
     *
     * @return null|string Trả về null nếu như kết quả nhận được từ eSMS không có mã code và ngược lại là message từ eSMS.
     */
    public function getMessage(): ?string
    {
        if ($code = $this->getCode()) {
            return static::$responseCodes[$code] ?? null;
        } else {
            return null;
        }
    }

}
