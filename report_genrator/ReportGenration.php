<?php

class ReportGenration {

    public $data = array();

    public function __construct() {
        
    }

    public function addData($testNumber, $testName, $input, $output, $result, $is_completed = TRUE, $problem = '') {
        $this->data[] = [
            'TestNumber' => $testNumber,
            'TestName' => $testName,
            'Input' => $input,
            'Output' => $output,
            'Result' => $result,
            'IsCompleted' => $is_completed,
            'Problem' => $problem
        ];
    }

    public function genrateReport() {
        
    }

}
