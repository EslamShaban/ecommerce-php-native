<?php

// Error Reporting

ini_set('disply_errors', 'On');
error_reporting(E_ALL);

include 'admin/Connect.php';

$sessionUser = '';

if(isset($_SESSION['user'])){
	$sessionUser = $_SESSION['user'];
}

$tpl  = "includes/templates/";
$lang = "includes/languages/";
$func = "includes/functions/";
$css  = "layout/css/";
$js   = "layout/js/";


// Include The Important Files 

include $lang . "english.php";

include $func . 'functions.php';
       
include $tpl  . 'header.php';



