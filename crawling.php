<?php
header('Content-Type: application/json;charset=UTF-8');
include "simple_html_dom.php";
if(!$_GET[page]) $page = 1;
else $page = $_GET[page];
$html = file_get_html("pasing address");
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
		$rel = false; // rel,9ative array?
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
	$json["success"] = "true";
	$json["code"] = "200";

	$i = 0;
	foreach($html->find('tr') as $article) {
		$json[$article->find('th', 0)->plaintext]['data'] = array($article->find('td', 0)->plaintext);
		$i++;
	}
	file_put_contents("./menu.json", json_encode2($json));
}
?>
