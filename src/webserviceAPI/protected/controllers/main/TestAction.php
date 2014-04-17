<?php
class TestAction extends CAction {

    public function run() {
        $dataJson = Functions::analyzeRequest();
        $result = MainOperation::test($dataJson);
        // var_dump($result);exit;
        SystemTool::exitWithJson(Functions::generateResult($result));
    }
}
