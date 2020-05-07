<?

include(__DIR__.'/covid19-php/main.php');

$covid = new COVID19();
$data = $covid->get_positives_count_last_days('東京', 5);
file_put_contents('test.json', json_encode($data));

?>
