<?php
/**
 * Created by PhpStorm.
 * User: 4d4k
 * Date: 2018/6/11
 * Time: 17:41
 */

namespace ShaoZeMing\Translate;


interface TranslateInterface
{

    public function translate($string,$source=false);
}