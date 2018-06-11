<?php

return [
    //使用什么翻译驱动
    // 目前支持这几种: "baidu", "youdao","google"
/*
 *  默认使用google
 */
    'defaults' => [
        'driver'  =>  'google',   //默认使用google翻译
        'spare_driver'  =>  'baidu',  // 备用翻译api ,第一个翻译失败情况下，调用备用翻译，填写备用翻译api 需要在下面对应的drivers中配置你参数
        'from' =>'zh-CH',   //原文本语言类型 ，目前支持：auto【自动检测】,en【英语】,zh【中文】，jp【日语】,ko【韩语】，fr【法语】，ru【俄文】，pt【西班牙】
        'to' =>'en',     //翻译文本 ：en,zh-CH,
    ],


    'drivers' =>[
        'baidu' => [
            'base_url'=>'http://api.fanyi.baidu.com/api/trans/vip/translate',
            //App id of the translation api
            'translate_appid' => '20180611000174972',
            //secret of the translation api
            'translate_secret' => 'cEXha7w4elaXO23NJ2Tt',
        ],

        'youdao' => [
            'base_url'=>'https://openapi.youdao.com/api',
            //App id of the translation api
            'translate_appid' => '',
            //secret of the translation api
            'translate_secret' => '',
        ],

        'google' => [
            'base_url'=>'http://translate.google.cn/translate_a/single',
            'translate_appid' => '',
            'translate_secret' => '',
        ],
    ],


];