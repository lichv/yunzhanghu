<?php
namespace Lichv\Yunzhanghu\Lib;

use Lichv\Yunzhanghu\Lib\Util\StringUtil;
class Config
{
    /**
     * 商户ID（由综合服务平台分配） 云账户·综合服务平台获取
     * @var string
     */
    public $dealer_id  = '';

    /**
     * 每个 request 的 id，要求每次请求 id 不⼀样，会在 response 中原样返回
     * @var string
     */
    public $request_id = '';

    /**
     * 综合服务主体ID   云账户·综合服务平台获取
     * @var string
     */
    public $broker_id  = '';

    /**
     * 随机数，⽤于签名
     * @var int
     */
    public $mess       = 0;

    /**
     * 时间戳，精确到秒
     * @var int
     */
    public $timestamp  = 0;

    /**
     * 加密key 云账户·综合服务平台获取
     * @var string
     */
    public $des3_key   = '';

    /**
     * 签名 云账户·综合服务平台获取
     * @var string
     */
    public $app_key    = '';

    /**
     * 构造函数
     * 初始化router和method
     */
    public function __construct(array $array)
    {
        $this->dealer_id = $array['dealer_id']??'';
        $this->broker_id = $array['broker_id']??'';
        $this->app_key = $array['app_key']??'';
        $this->des3_key = $array['des3_key']??'';
        $this->private_key = $array['private_key']??'';
        $this->public_key = $array['public_key']??'';
        $this->mess       = StringUtil::round(16);
        $this->timestamp  = time();
        $this->request_id = StringUtil::round(16);
    }

    public function __set($name, $value){
        $this->$name = $value;

    }
    
    public function __get($name){
        return $this->$name;
    }
}
