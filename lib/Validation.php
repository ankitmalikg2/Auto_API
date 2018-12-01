<?php

class Validation {

    public static function method_validation($value) {
        //$value = strtoupper($value);
        if ($value == "GET" || $value == "POST") {
            return TRUE;
        }
        return FALSE;
    }

    public static function timeout_validation($value) {
        return is_numeric($value) ? TRUE : FALSE;
    }
    
}
