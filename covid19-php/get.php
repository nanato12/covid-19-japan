<?php

include(__DIR__.'/config.php');

class Req extends Config {
    function __construct() {
        parent::__construct();
    }
    function get_request($url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function get_prefectures() {
        $response = $this->get_request($this->prefectures_url);
        return json_decode($response, true);
    }
    function get_total() {
        $response = $this->get_request($this->total_url);
        return json_decode($response, true);
    }
    function get_history() {
        $url = $this->total_url .'?history=true';
        $response = $this->get_request($url);
        return json_decode($response, true);
    }
    function get_predict() {
        $url = $this->total_url .'?predict=true';
        $response = $this->get_request($url);
        return json_decode($response, true);
    }
    function get_positives($pref) {
        $url = $this->positives_url ."?prefecture=${pref}";
        $response = $this->get_request($url);
        $data = json_decode($response, true);
        if (empty($data)) {
            $data = [];
        }
        return $data;
    }
    function get_statistics() {
        $response = $this->get_request($this->statistics_url);
        return json_decode($response, true);
    }
}

?>
