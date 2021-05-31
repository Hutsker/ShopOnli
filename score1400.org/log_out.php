<?php 
	require "db/connectt.php";	
  	$_SESSION['user'] = 0;
	$_SESSION['basket'] = [];	
	$_SESSION['sum'] = 0;
  	header('location: /index.php');
  ?> 