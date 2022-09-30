<?php
namespace Lichv\Yunzhanghu;

use Lichv\Yunzhanghu\Lib\Base;
use Lichv\Yunzhanghu\Lib\Service\BaseService;

class Yunzhanghu
{
    /**
     * 商户ID（由综合服务平台分配） 云账户·综合服务平台获取
     * @var string
     */
    private $config  = null;


    /**
     * Yunzhanghu constructor.
     * @param $ebussionid
     * @param $appkey
     */
    public function __construct($config=[])
    {
    	if (empty($config)) {
    		$config = [
                'dealer_id'=>env('YUNZHANGHU_DEALER',''),
                'broker_id'=>env('YUNZHANGHU_BROKER',''),
                'des3_key'=>env('YUNZHANGHU_DES3KEY',''),
                'app_key'=>env('YUNZHANGHU_APPKEY',''),
                'private_key'=>env('YUNZHANGHU_PRIVATEKEY',''),
                'public_key'=>env('YUNZHANGHU_PUBLICKEY',''),
            ];
    	}
    	$this->setConfig($config);

    }

    public function setConfig($config){
        if (!empty($config['private_key']) && strpos($config['private_key'],'-----BEGIN RSA PRIVATE KEY-----')===false) {
            $config['private_key'] = $this->getPrivateKey($config['private_key']);
        }
        if (!empty($config['public_key']) && strpos($config['public_key'],'-----BEGIN PUBLIC KEY-----')===false) {
            $config['public_key'] = $this->getPublicKey($config['public_key']);
        }
        $this->config = $config;
    	return $this;
    }

    public function submit($route string, $params array, $method="post"){
        $base = new Base($route, $method);
        foreach ($params as $key => $value) {
            $base->addParam($key, $value);  
        }

        $Goverify = new BaseService($this->config, $base);
        $fourVerifyRequest = $Goverify->request();
        return $fourVerifyRequest;
    }

    private function getPrivateKey($privateKey){
        return "-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap($privateKey, 64, "\n", true) ."\n-----END RSA PRIVATE KEY-----";
    }

    private function getPublicKey($publicKey){
        return "-----BEGIN PUBLIC KEY-----\n" . wordwrap($publicKey, 64, "\n", true) . "\n-----END PUBLIC KEY-----";
    }
}