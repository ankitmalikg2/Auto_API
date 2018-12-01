<?php

/*
 * ######### Algo #########
 * get the data from file
 * validate data
 * curl request
 * check data for valid output
 * add data to report_genrator OR call addData() function
 * repeat these step for next step
 * Genrate Report OR call genrateReport() function
 */
/*
  0] => Serial_Number
  [1] => TestName
  [2] => BaseURL
  [3] => RelativeURL
  [4] => Method(GET/POST)
  [5] => Input
  [6] => Output
  [7] => ConnectionTimeout(ms)
  [8] => TotalTimeout(ms)
  [9] => is_x-www-form-urlencoded(Yes/No)

 */

class Exection {

    public static function execute($fileName) {
          $summaryTotal = 0;
     $summaryPass = 0;
     $summaryFail = 0;
     $summaryValidationFail = 0;
     $summaryIncomplete = 0;
    
        $fileReader = new FileReader($fileName);
        $validation = new Validation();
        $reportGeneration = new ReportGeneration();
        $curlFunction = new CurlFunction();
        $libraryFunctions = new LibraryFunctions();
        $count = 0;

        //getting data from file
        $fileReader->getdata();
        while ($data = $fileReader->getdata()) {
            try {
                $count++;
                $summaryTotal++;
                echo "\n\nexecuting $count Test Case";
                $testNumber = isset($data[0]) ? trim($data[0]) : $count;
                $testName = isset($data[1]) ? trim($data[1]) : "Test-$count";
                $baseURL = isset($data[2]) ? $data[2] : "";
                $relativeURL = isset($data[3]) ? $data[3] : "";
                $method = isset($data[4]) ? strtoupper(trim($data[4])) : "";
                $input = isset($data[5]) ? $data[5] : "";
                $output = isset($data[6]) ? $data[6] : "";
                $ConnectionTimeout = isset($data[7]) ? $data[7] : "";
                $TotalTimeout = isset($data[8]) ? $data[8] : "";
                $is_x_www_form_urlencoded = isset($data[9]) ? $data[9] : "";
                $url = rtrim($baseURL, '/') . "/" . $relativeURL;

                if (!empty($input)) {
                    $input = json_decode($input, TRUE);
                }
                if (!empty($output)) {
                    $output = json_decode($output, TRUE);
                }

                //Connection timeout Resolution
                if (empty($ConnectionTimeout)) {
                    $ConnectionTimeout = 30000;
                }
                if (empty($TotalTimeout)) {
                    $TotalTimeout = 90000;
                }

                //Validation check
                if (!$validation->method_validation($method)) {
                    $summaryValidationFail++;
                    $reportGeneration->addData($testNumber, $testName, $baseURL, $relativeURL, $method, $input, $output, "", "V", "Method is not correct");
                    continue;
                }
                if (!$validation->timeout_validation($ConnectionTimeout)) {
                    $summaryValidationFail++;
                    $reportGeneration->addData($testNumber, $testName, $baseURL, $relativeURL, $method, $input, $output, "", "V", "Connection Timeout is not numeric");
                    continue;
                }

                if (!$validation->timeout_validation($TotalTimeout)) {
                    $summaryValidationFail++;
                    $reportGeneration->addData($testNumber, $testName, $baseURL, $relativeURL, $method, $input, $output, "", "V", "Total Timeout is not numeric");
                    continue;
                }

                //Curl call & Validate Data & add Data
                if ($method == "GET") {
                    list($status, $service_output) = $curlFunction->curl_get($url, $input, $ConnectionTimeout, $TotalTimeout);
                } elseif ($method == "POST") {
                    list($status, $service_output) = $curlFunction->curl_post($url, $input, $ConnectionTimeout, $TotalTimeout);
                }
                //validate

                if ($status == TRUE) {
                    $match_result = $libraryFunctions->check_output_matching($output, $service_output);
                    if ($match_result) {
                        $final_flag = "P";
                        $final_msg = "";
                        $summaryPass++;
                    } else {
                        $final_flag = "F";
                        $final_msg = "Given Output and API Output does not match.";
                        $summaryFail++;
                    }
                } else {
                    $final_flag = "I";
                    $final_msg = json_encode($service_output);
                    $summaryIncomplete++;
                }
                //add data for Report
                $reportGeneration->addData($testNumber, $testName, $baseURL, $relativeURL, $method, $input, $output, $service_output, $final_flag, $final_msg);
            } catch (Exception $ex) {
                //add data for exception Report
                $summaryValidationFail++;
                $reportGeneration->addData($testNumber, $testName, $baseURL, $relativeURL, $method, $input, $output, "", "V", "some error found in this test case");
            }
        }

        //Report Generation
        $reportGeneration->addSummaryData($summaryTotal, $summaryPass, $summaryFail, $summaryValidationFail, $summaryIncomplete);
        $reportGeneration->genrateReport();
    }

}

function run_script($config) {

    Exection::execute($config['File']);

    return "Success";
}
