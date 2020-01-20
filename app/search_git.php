<?php

if (!isset($_POST["rules"])) {
	header("Content-type: text/html; charset=utf-8");
	http_response_code(404);
	exit("rules not set");
}
$rules = json_decode($_POST["rules"], true);

$urlParts = [];
foreach($rules as $rule) {
	if ($rule["field"] && $rule["operator"] && $rule["value"]) {
		$urlParts[] = urlencode( "q=" . $rule["field"] . ":" . $rule["operator"] . $rule["value"] );
	}
}

if ($urlParts) {
	$url = "https://api.github.com/search/repositories?" . implode("&", $urlParts);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($curl);
	curl_close($curl);
}
else {
	$result = "";
}

exit($result);

?>
