# Kurs-API
<p>Just for fun. cURL beberapa website BANK di indonesia untuk mendapatkan KURS harga jual dan beli dollar ke rupiah and return ARRAY or JSON :)</p>
<h4>Install:</h4>
 

<pre>// include kurs.php
require("kurs.php");</pre>
 <h4>Example call function and return ARRAY:</h4>

<p>Menampilkan semua daftar nama BANK</p>
 

<pre>$data = bank();</pre>
 
<p>Menampilkan KURS berdasarkan nama BANK<br>
</p>
 

<pre>$data = kurs("bca");</pre>

<p>Atatu menampilkan KURS dari semua BANK<br>
</p>
 

<pre>$data = kurs("all");</pre>
 <h4>Convert ARRAY to JSON:</h4>
 

<pre>echo json_encode($data);</pre>

<h3><a href="http://ibacor.com/api/kurs">DEMO</a></h3>
