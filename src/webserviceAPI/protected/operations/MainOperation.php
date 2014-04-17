<?php
/*
** Author: huoyan
** Date: 2014-03-25
*/

class MainOperation
{
    public static function test($data) {
        $test = isset($data['test']) ? trim($data['test']) : null;
        if (empty($data)) {
            return SystemTool::buildResult(100, 'fail');
        }
        return SystemTool::buildResult(100, 'success', array('test' => $test));
    }
}
