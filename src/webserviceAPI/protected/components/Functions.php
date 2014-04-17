<?php

class Functions {
    public static function analyzeRequest()
    {
        // OpenSSL valid
        if (OpenSSL::checkSignMsg()) {
            return '';
        }

        $data = Yii::app()->request->getParam('d');
        $key = Yii::app()->request->getParam('s');
        $crc = Yii::app()->request->getParam('c');

//        return $dataJson = json_decode($data, true);

        if(!$data || !$key || !$crc)
        {
            return '';
        }

        $crcdata = crc32($data);
        $crckey = crc32($key);

        $crc_check = substr($crcdata, 0, 4) . substr($crckey, 0, 4);

        if($crc_check != $crc)
        {
            return '';
        }
        $result = array();
        $crypt = new DES(substr($key, 8, 8));
        $jsonStr = $crypt->decrypt(rawurldecode($data));
        $dataJson = json_decode($jsonStr, true);

        return $dataJson;
    }

    public static function generateResult($items)
    {
        $result = new stdClass();

        $key = md5(rand());
        $crypt = new DES(substr($key, 8, 8));
        $jsonitem = $crypt->encrypt(CJSON::encode($items));


        $result->d = $jsonitem;
        $result->s = $key;
        $result->c = substr(crc32($jsonitem),0,4).substr(crc32($key),0,4);

        return $result;
    }
}

?>