<?php
    /**
    * Author: huoyan
    * Time: 2014-04-17
    */
    class OpenSSL
    {
        public static function checkSignMsg() {
            $sign = Yii::app()->request->getParam('s');
            $signMsg = Yii::app()->request->getParam('d');
            $crt_file = Yii::app()->basePath."/vendor/openssl/wcp_rtn.crt";

            $pub_key_id = openssl_get_publickey(file_get_contents($crt_file));
            $verify_flag = openssl_verify($signMsg, base64_decode($sign), $pub_key_id, OPENSSL_ALGO_SHA1);
            openssl_free_key($pub_key_id);
            return ($verify_flag && $verify_flag == 1) ? true : false;
        }
    }
?>