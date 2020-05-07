<?php

include(__DIR__.'/get.php');

class COVID19 {
    function __construct() {
        $this->req = new Req();
    }
    function get_prefectures_data($prefName=null) {
        $data = [];
        foreach($this->req->get_prefectures() as $pref){
            $data[$pref['name_ja']] = ['id' => $pref['id']];
            foreach(['cases', 'deaths', 'pcr'] as $item){
                $data[$pref['name_ja']][$item] = [
                    'count' => $pref[$item],
                    'last_updated' => $pref['last_updated']["${item}_date"]
                ];
            }
        }
        if (!is_null($prefName)) {
            print($prefName);
            if (array_key_exists($prefName, $data)) {
                $data = $data[$prefName];
            } else {
                $data = [];
            }
        }
        return $data;
    }
    function get_total_data() {
        return $this->req->get_total();
    }
    function get_history_data($date=null) {
        $data = $this->req->get_history();
        if (!is_null($date)) {
            foreach($data as $item) {
                if (strcmp($date, $item['date'])==0) {
                    $data2 = $item;
                }
            }
            if (empty($data2)) {
                $data = [];
            } else {
                $data = $data2;
            }
        }
        return $data;
    }
    function get_predict_data($date=null) {
        $data = $this->req->get_predict();
        if (!is_null($date)) {
            foreach($data as $item) {
                if (strcmp($date, $item['date'])==0) {
                    $data2 = $item;
                }
            }
            if (empty($data2)) {
                $data = [];
            } else {
                $data = $data2;
            }
        }
        return $data;
    }
    function get_positives_data($pref) {
        return $this->req->get_positives($pref);
    }
    function get_positives_count_last_days($pref, $days=0) {
        $data = [];
        switch ($pref) {
            case '東京':
                $pref .= '都';
                break;
            case '大阪':
            case '京都':
                $pref .= '府';
                break;
            default:
                $pref .= '県';
        }
        foreach($this->req->get_positives($pref) as $item) {
            $announce_date = $item['announcement_date'];
            if (!array_key_exists($announce_date, $data)) {
                $data[$announce_date] = 0;
            }
            $data[$announce_date]++;
        }
        return array_slice($data, -$days);
    }
    function get_statistics_data() {
        return $this->req->get_statistics();
    }
}

?>
