<?php
namespace Lichv\Yunzhanghu\Lib;

class Base
{
    public $paramMap = [];

    public function __set($name, $value){
        $this->$name = $value;

    }
    public function __get($name){
        return $this->$name;
    }

    /**
     * 添加paramMap数组成员
     */
    public function addParam($key,$values,$ignoreSign =false){
        $this->paramMap[$key] = $values;
    }

    /**
     * 构造函数
     * 初始化router和method
     */
    public function __construct($router,$method = 'get')
    {
        $this->route = $router;
        $this->method = $method;
    }
    /**
     * 请求路由
     * @var string
     */
    protected $route  = '';

    /**
     * 请求方式
     * @var string
     */
    protected $method = 'get';

    /**
     * 获取请求路由
     * @return array
     */
    public function getRoute()
    {
        return [$this->route, $this->method];
    }
}
