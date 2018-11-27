<?php

class Functions {

    public function curl_post($url, $data, $con_timeout = '', $total_timeout = '') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //timeout
        if (!empty(trim($con_timeout))) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $con_timeout);
        }
        if (!empty(trim($total_timeout))) {
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, $total_timeout);
        }

        $output = curl_exec($ch);
        curl_close($ch);

        if (curl_errno($ch)) {
            return $this->curl_output_format(FALSE, curl_error($ch));
        }

        return $this->curl_output_format(TRUE, $output);
    }

    public function curl_get($url, $data, $con_timeout = '', $total_timeout = '') {

        $url = rtrim($url, '/') . "/?" . http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //timeout 
        if (!empty(trim($con_timeout))) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $con_timeout);
        }
        if (!empty(trim($total_timeout))) {
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, $total_timeout);
        }

        $output = curl_exec($ch);
        curl_close($ch);

        if (curl_errno($ch)) {
            return $this->curl_output_format(FALSE, curl_error($ch));
        }

        return $this->curl_output_format(TRUE, $output);
    }

    public function curl_output_format($status, $response) {
        return ["status" => $status, "response" => $response];
    }

}
