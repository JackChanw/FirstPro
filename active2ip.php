<?php
#########################################################################
# Author: Jackie Chan
# Created Time: 2014-07-21 11:33:52
# File Name: active2ip.php
# Description: 
#########################################################################
# php5.5.14
#-*- coding: utf-8 -*-
$host = array("Host: e.domob.cn");
$data = 'appId=896174222&udid=&ifa=B529B59F-5417-48A0-8A23-4AA6858A369A&oid=&appVersion=null&sign=575c2a943b09b0b7c4cac21c45bd00e2&acttime=1405910810689';
#$url = 'http://e.domob.cn/track/ow/api/postback';
$url = 'http://58.83.143.20/track/ow/api/postback';
var_dump( curl_post($host, $data,$url) );

/*
* 提交请求
* @param $host array 需要配置的域名 array("Host: act.qzone.qq.com");
* @param $data string 需要提交的数据 'user=xxx&qq=xxx&id=xxx&post=xxx'....
* @param $url string 要提交的url 'http://192.168.1.12/xxx/xxx/api/';
*/
 function curl_post($host,$data,$url)
    {
       $ch = curl_init();
       $res= curl_setopt ($ch, CURLOPT_URL,$url);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
       curl_setopt ($ch, CURLOPT_HEADER, 0);
       curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
       curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch,CURLOPT_HTTPHEADER,$host);
       $result = curl_exec ($ch);
       curl_close($ch);
       if ($result == NULL) {
           return 0;
       }
       return $result;
    }

# vim: set noexpandtab ts=4 sts=4 sw=4 :
