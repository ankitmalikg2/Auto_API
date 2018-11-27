<?php

class FileReader {

    public $file;
    public $file_handler;

    public function __construct($filename = "") {
        $this->file = (empty($filename)) ? "../data/default.csv" : "../data/$filename";

        $this->file_handler = fopen($this->file, 'r');
    }

    public function getCSV($filename = "") {
        if (!feof($this->file_handler)) {
            return fgetcsv($file_handler);
        }
        return FALSE;
    }
    
    public function file_close(){
        fclose($this->file_handler);
    }

}
