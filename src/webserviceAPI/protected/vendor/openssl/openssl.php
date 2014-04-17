<?php
public static function checkSignMsgPKI($merchantId = 0)
    {
        if(!isset($merchantId) || intval($merchantId)<=0)
        {
            return false;
        }
        $merchantId = intval($merchantId);
        $merchant_file = @dirname(__FILE__)."/../../conf/merchantConfig/".$merchantId."/request.crt";

        $q_str = @$_SERVER['QUERY_STRING'];
        if(!isset($q_str) || @$q_str == ""){
            return false;
        }
        parse_str($q_str,$q_arr);
        if(!isset($q_arr) && !is_array($q_arr) || count($q_arr)<=0 || !isset($q_arr['signMsg']) || @$q_arr['signMsg'] == ""){
            return false;
        }
        $signMsg = $q_arr['signMsg'];

        //$q_arr = array_change_key_case($q_arr,CASE_LOWER);//键名转小写
        ksort($q_arr);//排序

        $params_str = "";
        foreach ($q_arr as $key=>$val)
        {
            if($key!="signMsg" && $key!="signmsg")
            {
                $val = $q_arr[$key];
                $params_str .= $key."=".$val."&";
            }
        }
        $params_str = trim($params_str,"&");

        $pub_key_id = openssl_get_publickey(file_get_contents($merchant_file));
        $verify_flag = openssl_verify($params_str, base64_decode($signMsg), $pub_key_id,OPENSSL_ALGO_SHA1);
        openssl_free_key($pub_key_id);

        return ($verify_flag && $verify_flag==1)?true:false;
    }

    public static function getSignMsgPKI($msg_arr = array())
    {
        $signMsg = "";
        if(!isset($msg_arr) || !is_array($msg_arr) || count($msg_arr)<=0)
        {
            return $signMsg;
        }

        $merchant_file = @dirname(__FILE__)."/../../conf/merchantConfig/wcp_rtn.key";

        //$msg_arr = array_change_key_case($msg_arr,CASE_LOWER);//键名转小写
        ksort($msg_arr);//排序

        $params_str = "";
        foreach ($msg_arr as $key=>$val)
        {
            if($key!="signMsg" && $key!="signmsg")
            {
                $val = $msg_arr[$key];
                $params_str .= $key."=".$val."&";
            }
        }
        $params_str = trim($params_str,"&");

        $priv_key_id = openssl_get_privatekey(file_get_contents($merchant_file));
        openssl_sign($params_str, $signature, $priv_key_id ,OPENSSL_ALGO_SHA1);
        $signMsg = base64_encode($signature);
        openssl_free_key($priv_key_id);
        return $signMsg;
    }

    public static function getSignMsgPKIDemo($merchantId = 0, $param_arr = array())
    {
        $signMsg = "";
        if(!isset($merchantId) || intval($merchantId)<=0
            || !isset($param_arr) || !is_array($param_arr) || count($param_arr)<=0)
        {
            return $signMsg;
        }
        $merchantId = intval($merchantId);
        $merchant_file = @dirname(__FILE__)."/../../conf/merchantConfig/".$merchantId."/request.key";

        //$msg_arr = array_change_key_case($param_arr,CASE_LOWER);//键名转小写
        ksort($param_arr);//排序

        $params_str = "";
        foreach ($param_arr as $key=>$val)
        {
            if($key!="signMsg" && $key!="signmsg")
            {
                $val = $param_arr[$key];
                $params_str .= $key."=".$val."&";
            }
        }
        $params_str = trim($params_str,"&");

        $priv_key_id = openssl_get_privatekey(file_get_contents($merchant_file));
        openssl_sign($params_str, $signature, $priv_key_id ,OPENSSL_ALGO_SHA1);
        $signMsg = base64_encode($signature);
        openssl_free_key($priv_key_id);
        return $signMsg;
    }
?>