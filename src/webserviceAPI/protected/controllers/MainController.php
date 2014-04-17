<?php
/**
 * WifiController is the default controller to handle user requests.
 */
/**
 * 作者：jieqiang
 * 修改说明：wifiController.php
 * 配置获取当前热点详细信息
 * 修改'getAPDetail' => 'application.controllers.wifi.GetAPDetailAction'
 * 修该时间：2014-3-5 上午10:12:08
 * 版本：v
 */
class MainController extends CController {
    public function actions() {
        return array(
            'test' => 'application.controllers.main.TestAction',
        );
    }
}
