<?php

namespace Lichv\Yunzhanghu\Lib\Service;

use Lichv\Yunzhanghu\Lib\Base;
use Lichv\Yunzhanghu\Lib\Config;
use Lichv\Yunzhanghu\Lib\HttpRequest;
use Lichv\Yunzhanghu\Lib\Util\RSAUtil;
use Lichv\Yunzhanghu\Lib\Service\Des3Service;

class BaseService
{
    /**
     * 相关参数
     * @var Base
     */
    public $data;

    /**
     * 相关配置
     * @var Config
     */
    protected $config;

    /**
     * 构造函数
     */
    public function __construct(Config $config,Base $data)
    {
        $this->config = $config;
        $this->data = $data;
    }

    /**
     * 取数据并封装成数组
     */

    protected function getDes3Data()
    {
        $data = [];
        foreach ($this->data as $k => $v) {
            if(is_array($v)){
                foreach ($v as $key => $item) {
                    $data[$key] = $item;
                }
            }else {
                $data[$k] = $v;
            }
        }
        return $data;
    }

    /**
     * 获取请求消息
     */
    protected function getRequestInfo()
    {
        return $this->data->getRoute();
    }

    /**
     * 获取头信息
     */
    protected function getHeader()
    {
        return [
            'Content-Type: application/x-www-form-urlencoded',
            "dealer-id: {$this->config->dealer_id}",
            "request-id: {$this->config->request_id}",
        ];
    }


    /**
     * 构造Request信息
     */
    protected function getRequestData()
    {

        $desData  = Des3Service::encode($this->getDes3Data(), $this->config->des3_key);
        $signData = "data=".$desData."&mess=".$this->config->mess."&timestamp=".$this->config->timestamp."&key=".$this->config->app_key;

        $rsa = new RsaUtil($this->config);
        $sign = $rsa->sign($signData);
        $postData              = [];
        $postData['data']      = $desData;
        $postData['mess']      = $this->config->mess;
        $postData['timestamp'] = $this->config->timestamp;
        $postData['sign']      = $sign;
        $postData['sign_type'] = 'rsa';
        return $postData;
    }

    /**
     * 发起请求
     * @var(callback 异步回传地址，为空则不回传)
     * 返回请求解密结果
     */
    public function request($callback = null)
    {
        $requestData = $this->getRequestData();
        $header      = $this->getHeader();
        $requestInfo = $this->getRequestInfo();
        $method      = $requestInfo[1] ==null?'get':$requestInfo[1];
        $request  = new HttpRequest($requestInfo[0]);
        $result     = $request
                      ->setHeader($header)
                      ->$method($requestData)
                      ->getBodyJson();

        //返回结果解密
        if(isset($result['data']) && is_string($result['data'])){
            $result['data'] = Des3Service::decode($result['data'], $this->config->des3_key);
        }
        return $result;
    }


}
