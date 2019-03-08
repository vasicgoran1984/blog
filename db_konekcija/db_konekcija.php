<?php 
	// Konekcija do baze
	$dbhost     = 'localhost';
	$dbkorisnik = 'root';
	$dbpasword  = 'root';
	$dbime      = 'db_blog';
        
	$konekcija = new mysqli($dbhost, $dbkorisnik, $dbpasword, $dbime);
	
	// Test konekcije
	if (mysqli_connect_errno()) {
		die('Konekcija ne radi ' .
			mysqli_connect_error() . 
			' (' . mysqli_connect_errno() . ')'
		);
	} else {
		//echo 'Konekcija uspjesna!' . '<br/>';
	}