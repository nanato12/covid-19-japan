<?php

class Config {
    private $host = 'https://covid19-japan-web-api.now.sh/api/v1/';
    function __construct() {
        $this->prefectures_url = $this->host.'prefectures';
        $this->total_url = $this->host.'total';
        $this->positives_url = $this->host.'positives';
        $this->statistics_url = $this->host.'statistics';
    }
}

?>
