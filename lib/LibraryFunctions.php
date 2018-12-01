<?php

class LibraryFunctions {

    public function check_output_matching($output, $service_response) {
        foreach ($output as $key => $value) {

            if (!array_key_exists($key, $service_response)) {               
                return FALSE;
            }

            if (is_array($value)) {
                $result = $this->check_output_matching($value, $service_response[$key]);
                if (!$result) {
                    return FALSE;
                }
            }
            
            unset($service_response[$key]);
            
        }
        if(!empty($service_response)){
            return FALSE;
        }
        return TRUE;
    }

}
