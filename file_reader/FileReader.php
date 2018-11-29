<?php

class FileReader {

    public $file;
    public $file_handler;

    public function __construct($filename = "") {
        $this->file = (empty($filename)) ? dirname(__FILE__)."/../data/default.csv" : dirname(__FILE__)."/../data/$filename";
        //opening file in read mode
        $this->file_handler = fopen($this->file, 'r');
    }

    public function getdata() {
        if (!feof($this->file_handler)) {
            return fgetcsv($this->file_handler);
        }
        
        fclose($this->file_handler);
        return FALSE;        
    }
    
    public function file_close(){
        fclose($this->file_handler);
    }

}
