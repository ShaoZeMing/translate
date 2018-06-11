<?php
namespace ShaoZeMing\Translate;

use GuzzleHttp\Client;
use ShaoZeMing\Translate\Exceptions\TranslateException;

class Baidu implements TranslateInterface
{

    protected static $language = [
        '' =>'auto',   //中文
        'auto' =>'auto',   //中文
        'zh' =>'zh',   //中文
        'en' =>'en',   //英文
        'jp' =>'jp',   //日文
        'ko' =>'kor',  //韩文
        'fr' =>'fra',  //法语
        'ru' =>'ru',   //俄语
        'es' =>'spa',  //西班牙语
        'pt' =>'pt',  //葡萄牙语
    ];


    private $app_id;
    private $app_key;
    private $base_url;
    private $options;
    private $httpClient;
    private $from;
    private $to;
    public $source = false;


    public function __construct($app_id,$app_key,$from,$to,$base_url,$options=[])
    {
        $this->app_id = $app_id;
        $this->app_key = $app_key;
        $this->from = $this->checkLanguage($from);
        $this->to = $this->checkLanguage($to);
        $this->base_url = $base_url;
        $this->options = $options;
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
        $this->httpClient = new Client($this->options); // Create HTTP client
        $query = $this->getQueryData($string);
        $url = $this->base_url.'?'.http_build_query($query);
        $response = $this->httpClient->get($url);
        $result = json_decode($response->getBody(), true);
        return $this->response($result);

    }


    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $string
     * @return array
     */
    private function getQueryData($string){
        $salt = time();
        $query=[
            "from"  => $this->from,
            "to"    => $this->to,
            "appid" => $this->app_id,
            "q" => $string,
            "salt" => $salt,
            "sign" => $this->getSign($string , $salt),
        ];

        return $query;
    }

    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $language
     * @return mixed
     * @throws TranslateException
     */
    private static function checkLanguage($language)
    {

        if (!isset(self::$language[$language])) {
            throw new TranslateException('10000');
        }

        return self::$language[$language];
    }


    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $result
     * @return mixed
     * @throws TranslateException
     */
    private function response($result)
    {

        if (is_array($result) && isset($result['error_code'])){
            throw new TranslateException($result['error_code']);
        }

        if(is_array($result) && isset($result['trans_result'])){
            if($this->source){
                return $result;
            }
           return  $result['trans_result'][0]['dst'];
        }
        throw new TranslateException(10003);
    }


    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $string
     * @param $time
     * @return string
     */
    private function getSign($string,$time)
    {
        $str = $this->app_id . $string . $time . $this->app_key;
        return   md5($str);    }


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