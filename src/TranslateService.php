<?php

namespace ShaoZeMing\Translate;

use Stichoza\GoogleTranslate\TranslateClient;

class TranslateService implements TranslateInterface
{



    private $driver;
    private $spare_driver;
    private $config =[];
    private $options=[];
    private $from;
    private $to;
    public $source = false;



    public function __construct($config=[])
    {
        $this->config=$config;
        if(!count($config)){
            $this->config = include(__DIR__.'/../config/translate.php');
        }

        $this->driver = $this->config['defaults']['driver'];
        $this->spare_driver = $this->config['defaults']['spare_driver'];
        $this->from = $this->config['defaults']['from'];
        $this->to = $this->config['defaults']['to'];
    }



    public function setDriver($driver){

        $this->driver = $driver;
        return $this;
    }



    public function setFromTo($from,$to){

        $this->from = $from;
        $this->to = $to;
        return $this;
    }


    public function setHttpOption($options = []){
        $this->options = $options;
        return $this;
    }




    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $string
     * @param bool $source  返回原数据结构
     * @return mixed
     */
    public function translate($string,$source=false)
    {
        $this->source=$source;
        $driver = $this->driver;
        $appKey = $this->config[$driver]['app_key'];
        $appId = $this->config[$driver]['app_id'];
        $baseUrl = $this->config[$driver]['base_url'];
        switch ($driver){
            case 'baidu':
                $driver = new Baidu($appId,$appKey,$this->from,$this->to,$baseUrl,$this->options);
                break;
            case 'youdao':
                $driver = new YouDao($appId,$appKey,$this->from,$this->to,$baseUrl,$this->options);
                break;
            case 'google':
                $tr = new TranslateClient('zh-CN', 'en');
                $tr->setUrlBase($baseUrl);
                break;
        }



    }





    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $attr
     * @param $value
     * @return $this
     */
    public function __set($attr,$value)
    {
        $this->$attr = $value;
        return $this;
    }


    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $attr
     * @return mixed
     */
    public function __get($attr)
    {
        return $this->$attr;
    }



}
