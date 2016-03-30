<?php

	// include kurs.php
	require("kurs.php");
	
	$bank = (!empty($_GET["bank"]) ? $_GET["bank"] : "");
	
	// call function and return array print_r($data);
	if(!empty($bank)){
		$data = kurs($bank);
	}else{
		$data = bank();
	}
	
	// JSON
	header('Content-Type: application/json');
	
	// mengijinkan semua host/domain/ip untuk menggunakan data JSON ini bila menggunakan AJAX
	// atau rubah tanda * menjadi domain yg di tentukan
	header('Access-Control-Allow-Origin: *');
	
	// convert array to JSON
	echo stripslashes(preg_replace("/\\\\u([a-f0-9]{4})/e", "", json_encode($data, JSON_PRETTY_PRINT)));
	
?>
