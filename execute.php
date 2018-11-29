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

class Exection{
    public static function execute($fileName){
        $fileReader = new FileReader($fileName);
        while ($data=$fileReader->getdata()){
            print_r($data);
        }
    }
}


function run_script($config){
    
    Exection::execute($config['File']);
    
    return "Success";
}

