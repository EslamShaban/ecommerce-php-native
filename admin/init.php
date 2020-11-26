<?php

include 'Connect.php';

$tpl  = "includes/templates/";
$lang = "includes/languages/";
$func = "includes/functions/";
$css  = "layout/css/";
$js   = "layout/js/";


// Include The Important Files 

include $lang . "english.php";

include $func . 'functions.php';
       
include $tpl  . 'header.php';

if(!isset($noNavbar)){
    include $tpl  . 'Navbar.php';
}

