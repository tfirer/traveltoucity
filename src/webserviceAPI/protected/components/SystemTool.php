<?php
class SystemTool {
    public static function exitWithResult($result) {
        echo $result;
        exit(0);
    }

    public static function exitWithJson($res) {
        echo header("Content-Type: text/json;charset=utf-8");
        echo CJSON::encode($res);
        exit(0);
    }

    public static function buildResult($code, $msg, $data = array()) {
        return array(
            'code' => $code ,
            'msg' => $msg ,
            'data' => $data ,
        );
    }

    public static function currentTime() {
        return date('Y-m-d H:m:s', time());
    }

    public static function filterWifi($result) {
		$data = array();
        $size = count($result);
        if ($size > 100) {
            foreach ($result as $index=>$value) {
                if ($index > 100) break;
                if (($index % round($size/100)) == 0) {
                    $ap = $value;        
		    	    $data[] = array(
		    	    	'wid' => $ap->wid ,
		    	    	'ssid' => $ap->SSID ,
		    	    	'lat' => $ap->latitude ,
		    	    	'lng' => $ap->longitude ,
		    	    	'wifiType' => $ap->wifiType ,
		    	    );
                }
            }
        } else {
		    foreach ($result as $ap) {
		    	$data[] = array(
		    		'wid' => $ap->wid ,
		    		'ssid' => $ap->SSID ,
		    		'lat' => $ap->latitude ,
		    		'lng' => $ap->longitude ,
		    		'wifiType' => $ap->wifiType ,
		    	);
		    }
        }
        return $data;
    }
}

/* End fo file SystemTool.php */
/* Location: ./protect/Componente/SystemTool.php */
