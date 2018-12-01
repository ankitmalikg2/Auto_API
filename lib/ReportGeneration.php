<?php

class ReportGeneration {
    /* 4 types of Flags
      P - Passed
      F - Failed
      I - incomplete
      V - validation failed
     */

    public $data = array();
    public $summaryData = array();

    public function __construct() {
        
    }

    public function addData($testNumber, $testName, $baseURL, $relativeURL, $method, $input, $output, $serviceOutput, $flag, $message = '') {
        $this->data[] = [
            'TestNumber' => $testNumber,
            'TestName' => $testName,
            "BaseURL" => $baseURL,
            "RelativeURL" => $relativeURL,
            "method" => $method,
            'Input' => $input,
            'Output' => $output,
            'ServiceOutput' => $serviceOutput,
            'Flag' => $flag,
            'Message' => $message
        ];
    }

    public function addSummaryData($total,$pass,$fail,$vaidationFail,$incomplete){
        $this->summaryData=array($total,$pass,$fail,$vaidationFail,$incomplete);
    }


    public function getFileName() {
        return date("d-m-Y_H:i:s") . "_report.html";
    }

    public function genrateReport() {
        echo "\nReport Generation Started";
        //Code for Report Generation
        $reportTemplate = new ReportTemplate();
        $fileName = $this->getFileName();
        $fileHandler = fopen(dirname(__FILE__) . "/../reports/$fileName", "a");
        fwrite($fileHandler, $reportTemplate->header());
        fwrite($fileHandler, $reportTemplate->summarySection($this->summaryData[0], $this->summaryData[1], $this->summaryData[2], $this->summaryData[3], $this->summaryData[4]));
        fwrite($fileHandler, $reportTemplate->topSection());


        $index = 0;
        foreach ($this->data as $row) {
            $index++;
            $testCaseResult = "";

            if ($row['Flag'] == "P") {
                $testCaseResult = $reportTemplate->pass($index, $row['TestName'], $row['Input'], $row['Output'], $row['ServiceOutput']);
            } elseif ($row['Flag'] == "F") {
                $testCaseResult = $reportTemplate->fail($index, $row['TestName'], $row['Input'], $row['Output'], $row['ServiceOutput'], $row['Message']);
            } elseif ($row['Flag'] == "I") {
                $testCaseResult = $reportTemplate->incomplete($index, $row['TestName'], $row['Input'], $row['Output'], $row['ServiceOutput'], $row['Message']);
            } elseif ($row['Flag'] == "V") {
                $testCaseResult = $reportTemplate->validationFail($index, $row['TestName'], $row['Input'], $row['Output'], $row['ServiceOutput'], $row['Message']);
            }
            fwrite($fileHandler, $testCaseResult);
        }

        fwrite($fileHandler, $reportTemplate->bottomSection());
        fwrite($fileHandler, $reportTemplate->footer());

        echo "\nReport Generation Completed\n";
    }

}
