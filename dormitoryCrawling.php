<?php
    header("Refresh:300");
    header('Content-Type: application/json;charset=UTF-8');
    include "simple_html_dom.php";
    if(!$_GET[page]) $page = 1;
    else $page = $_GET[page];
	$url = "http://dormitory.tu.ac.kr/default/main/main.jsp";
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
		foreach($html->find('dl') as $article) {
			$json["조식"]['data'] = array($article->find('dd', 0)->plaintext);
      $json["석식"]['data'] = array($article->find('dd', 1)->plaintext);
      $i++;
      file_put_contents("./dormiMenu/".$tt."dormitoryMenu.json", json_encode2($json));
    }

    }
?>
