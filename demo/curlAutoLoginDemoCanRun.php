<?php

require_once __DIR__.'/../vendor/autoload.php';

$autologin = new PhpUtility\CurlAutoLogin();

//0. 未登录
$getDataUrl = 'http://demo.zjmainstay.cn/js/simpleAjax/loginResult.php';
echo 'Before Login: ' . $autologin->getUrl($getDataUrl) . "\n";

//1. 初始化登录页
$firstCurl = "curl 'http://demo.zjmainstay.cn/js/simpleAjax/' -H 'Host: demo.zjmainstay.cn' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:47.0) Gecko/20100101 Firefox/47.0' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' -H 'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3' -H 'Accept-Encoding: gzip, deflate' -H 'Cookie: Hm_lvt_1526d5aecf5561ef9401f7c7b7842a97=1468327822,1468327904,1468341636,1468411918; Hm_lpvt_1526d5aecf5561ef9401f7c7b7842a97=1468421526' -H 'Connection: keep-alive' -H 'If-Modified-Since: Mon, 27 Oct 2014 08:31:18 GMT' -H 'If-None-Match: \"32e-453-506635ac5e180\"' -H 'Cache-Control: max-age=0'";
$autologin->execCurl($firstCurl);

//2. 提交登录表单
$secondCurl = "curl 'http://demo.zjmainstay.cn/js/simpleAjax/doPost.php' -H 'Host: demo.zjmainstay.cn' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:47.0) Gecko/20100101 Firefox/47.0' -H 'Accept: application/json, text/javascript, */*; q=0.01' -H 'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3' -H 'Accept-Encoding: gzip, deflate' -H 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8' -H 'X-Requested-With: XMLHttpRequest' -H 'Referer: http://demo.zjmainstay.cn/js/simpleAjax/' -H 'Cookie: Hm_lvt_1526d5aecf5561ef9401f7c7b7842a97=1468327822,1468327904,1468341636,1468411918; Hm_lpvt_1526d5aecf5561ef9401f7c7b7842a97=1468421526' -H 'Connection: keep-alive' --data 'username=demousername'";
$realUsername = 'Zjmainstay';
//前置处理，替换错误的用户名
$autologin->execCurl($secondCurl, function($parseCurlResult) use ($realUsername) {
        $parseCurlResult['post'] = str_replace('=demousername', "={$realUsername}", $parseCurlResult['post']);
        return $parseCurlResult;
    });

//3. 登录成功，锁定cookie的更新，直接访问已登录页面内容
$autologin->lockLastCookieFile();
echo 'After Login: ' . $autologin->getUrl($getDataUrl) . "\n";
