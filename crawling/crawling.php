<?php
    header("Refresh:1000");
    header('Content-Type: application/json;charset=UTF-8');
    include "simple_html_dom.php";
    if(!$_GET[page]) $page = 1;
    else $page = $_GET[page];
	$url = "http://tusso.tu.ac.kr/jsp/manage/restaurant/restaurant_menu.jsp";
    $ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $str = curl_exec($ch);

	curl_close($ch);

	$html = str_get_html($str);

    $tt = date("Ymd");

	function json_encode2($data) {
	switch (gettype($data)) {
		case 'boolean':
		return $data?'true':'false';
		case 'integer':
		case 'double':
		return $data;
		case 'string':
		return '"'.strtr($data, array('\\'=>'\\\\','"'=>'\\"')).'"';
		case 'array':
		$rel = false; // relative array?
		$key = array_keys($data);
		foreach ($key as $v) {
		if (!is_int($v)) {
		$rel = true;
		break;
		}
		}
		$arr = array();
		foreach ($data as $k=>$v) {
		$arr[] = ($rel?'"'.strtr($k, array('\\'=>'\\\\','"'=>'\\"')).'":':'').json_encode2($v);
		}
		return $rel?'{'.join(',', $arr).'}':'['.join(',', $arr).']';
		default:
		return '""';
		}
	}
    if($html)
    {
		$i = 0;
		foreach($html->find('tr') as $article) {
			$json[$article->find('th', 0)->plaintext."M".$i]['data'] = array($article->find('td', 0)->plaintext);
			$i++;
      file_put_contents("./univMenu/".$tt."menu.json", json_encode2($json));
    }

    }
?>
