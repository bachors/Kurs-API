<?php

/* Just for fun code by ibacor.com */

// Menyembunyikan pesan error karena proses DOM yang tidak sempurna 
error_reporting(0);

function ayoCurl($bank, $url, $td, $field1, $field2, $user_agent = "Googlebot/2.1 (http://www.googlebot.com/bot.html)")
{
    $url = $url;
    $ch = curl_init();
	
	curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
	
	// jika website yd di curl sedang offline
	if(!$content = curl_exec($ch)){
		$arrai = array(
			"bank" => $bank,
			"status" => "offline",
			"kurs" => array()
		);
		return $arrai;
	}
	
	// ternyata website yd di curl sedang online
	else{
		curl_close($ch);
		$dom = new DOMDocument;
		$dom->loadHTML($content);
		$rows = array();
		foreach ($dom->getElementsByTagName('tr') as $tr) {
			$cells = array();
			foreach ($tr->getElementsByTagName('td') as $r) {
				$cells[] = $r->nodeValue;
			}
			$rows[] = $cells;
		}		
		
		$jual = preg_replace('/\s+/', '', $rows[$td][$field1]);
		$beli = preg_replace('/\s+/', '', $rows[$td][$field2]);
		
		if(substr($jual, -3) == ".00"){
			$jual = str_replace(".00", "", $jual);
		}else if(substr($jual, -3) == ",00"){
			$jual = str_replace(",00", "", $jual);
		}
		
		if(substr($beli, -3) == ".00"){
			$beli = str_replace(".00", "", $beli);
		}else if(substr($beli, -3) == ",00"){
			$beli = str_replace(",00", "", $beli);
		}
		
		$search  = array(",", ".");
		$replace = array("", "");
		$jual = str_replace($search, $replace, $jual);
		$beli = str_replace($search, $replace, $beli);
		
		$arrai = array(
			"bank" => $bank,
			"status" => "online",
			"kurs" => array(
				"mata_uang" => "USD",
				"jual" => $jual,
				"beli" => $beli
			)
		);
		return $arrai;
	}
}

function curl(){
	
	$data = array();
	$data[] = ["bank" => "bi", "url" => "http://www.bi.go.id/id/moneter/informasi-kurs/transaksi-bi/Default.aspx",	"td" => "31", "field1" => "2", "field2" => "3"];
	$data[] = ["bank" => "bca", "url" => "http://www.bca.co.id/id/Individu/Sarana/Kurs-dan-Suku-Bunga/Kurs-dan-Kalkulator",	"td" => "2", "field1" => "1", "field2" => "2"];
	$data[] = ["bank" => "permata", "url" => "https://www.permatabank.com/kurs/", "td" => "1", "field1" => "4", "field2" => "3"];
	$data[] = ["bank" => "bni", "url" => "http://www.bni.co.id/informasivalas.aspx", "td" => "14", "field1" => "1", "field2" => "2"];
	$data[] = ["bank" => "bri", "url" => "http://www.bri.co.id/rates", "td" => "22", "field1" => "2", "field2" => "1"];
	$data[] = ["bank" => "bukopin", "url" => "http://www.bukopin.co.id/", "td" => "3", "field1" => "2", "field2" => "1"];
	$data[] = ["bank" => "danamon", "url" => "http://www.danamon.co.id/Home/AboutDanamon/FXRates/tabid/272/language/id-ID/Default.aspx", "td" => "1", "field1" => "2", "field2" => "1"];
	$data[] = ["bank" => "mandiri", "url" => "http://www.bankmandiri.co.id", "td" => "3", "field1" => "3", "field2" => "2"];
	$data[] = ["bank" => "ekonomi", "url" => "https://www.bankekonomi.co.id/1/2/home/kurs-mata-uang", "td" => "2", "field1" => "2", "field2" => "1"];
	$data[] = ["bank" => "mega", "url" => "https://www.bankmega.com/treasury.php", "td" => "3", "field1" => "2", "field2" => "1"];
	$data[] = ["bank" => "mybank", "url" => "http://www.maybank.co.id/kurs/pages/kurs.aspx", "td" => "11", "field1" => "2", "field2" => "1"];
	$data[] = ["bank" => "bankjatim", "url" => "http://www.bankjatim.co.id/id/informasi/informasi-lainnya/kurs", "td" => "3", "field1" => "3", "field2" => "2"];
	$data[] = ["bank" => "btn", "url" => "http://www.btn.co.id/id/content/BTN-Info/Info/Kurs-Valuta-Asing", "td" => "1", "field1" => "1", "field2" => "2"];
	$data[] = ["bank" => "bjb", "url" => "http://www.bankbjb.co.id/id/corporate-website/rate-dan-biaya/kurs-valas.html", "td" => "8", "field1" => "2", "field2" => "1"];
	$data[] = ["bank" => "bankmuamalat", "url" => "http://www.bankmuamalat.co.id/kurs", "td" => "2", "field1" => "3", "field2" => "4"];
	$data[] = ["bank" => "banksinarmas", "url" => "http://banksinarmas.com/id/i.php?id=charges-atm", "td" => "11", "field1" => "2", "field2" => "1"];
	$data[] = ["bank" => "bankaltim", "url" => "http://www.bankaltim.co.id/kurs", "td" => "7", "field1" => "1", "field2" => "2"];
	
	/* Sobat bisa menambahkan lagi daftar bank yang akan di cURL ^^
	$data[] = ["bank" => "nama bank", "url" => "url bank yang akan di cURL", "td" => "array td ke", "field1" => "array field ke di dalam td (jual)", "field2" => "array field ke di dalam td (beli)"];
	*/
	
	return $data;
	
}

function bank(){

	$curl = curl();
	
	$data = array();

	foreach($curl as $cr){
		$url_kurs = 'http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI].'?bank='.$cr['bank'];
		$data['data'][] = array(
			"bank" => $cr['bank'],
			"url_kurs" => $url_kurs
		);
	}
	
	$data['data'][] = array(
		"bank" => "all",
		"url_kurs" => 'http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI].'?bank=all'
	);
	
	return $data;

}

function kurs($bank = ""){

	$curl = curl();
	
	$data = array(
		"date" => date("d/m/Y")
	);

	foreach($curl as $cr){
		if($cr['bank'] == $bank){
			$data['data'][] = ayoCurl($cr['bank'], $cr['url'], $cr['td'], $cr['field1'], $cr['field2']);
		}else if($bank == "all"){
			$data['data'][] = ayoCurl($cr['bank'], $cr['url'], $cr['td'], $cr['field1'], $cr['field2']);
		}
	}	
	
	return $data;

}
