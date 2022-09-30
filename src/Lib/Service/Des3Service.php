<?php

namespace Lichv\Yunzhanghu\Lib\Service;

use Lichv\Yunzhanghu\Lib\Util\DesUtil;

class Des3Service
{
    /**
     * 3DES加密方法
     */
    public static function encode(array $data, $des3Key)
    {
        $DesUtil = new DesUtil($des3Key);
        return $DesUtil->encrypt(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 3DES解密方法
     */
    public static function decode( $dec3Value,  $des3Key)
    {
        $DesUtil = new DesUtil($des3Key);
        return json_decode($DesUtil->decrypt($dec3Value), true);
    }
}
