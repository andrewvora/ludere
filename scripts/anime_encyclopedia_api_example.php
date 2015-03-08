<?php

for($i = 17; $i <= 17; $i++){
	echo "STARTING...\n";
	$url = "http://cdn.animenewsnetwork.com/encyclopedia/api.xml?anime=$i";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	$result = curl_exec($ch);
	curl_close($ch);

	//convert XML -> JSON -> array
	$result = str_replace(array("\n","\t","\r"), '', $result);
	$result = trim(str_replace('"', "'", $result));
	$result = simplexml_load_string($result);

	if($result != null && isset($result)) {
		print_r((string)$result->anime->info[10]);
	}
}

?>