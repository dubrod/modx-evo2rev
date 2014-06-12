<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);

//set database
$db = file_get_contents('database_backup.sql');


//eForms
$eforms = "eForm?";
echo "<br><strong>eForms:</strong> appears " . substr_count($db, $eforms) . " times.<br>";

//dittos
$dittos = "Ditto?";
echo "<br><strong>dittos:</strong> appears " . substr_count($db, $dittos) . " times.<br>";

//AjaxSearch
$asearch = "AjaxSearch?";
echo "<br><strong>AjaxSearch:</strong> appears " . substr_count($db, $asearch) . " times.<br>";


//SNIPPETS

$snippets = array("Breadcrumbs","Ditto","eForm","FirstChildRedirect","if","Jot","ListIndexer","AjaxSearch");

echo "<br><strong>SNIPPPETS</strong><br>";

//start counting
foreach($snippets as $s){
	echo "".$s." appears " . substr_count($db, $s) . " times.<br>";
}

//CHUNKS

$chunks = array("WebLoginSideBar","top_nav","apply_form","side_nav","outerTp","main_rowTp");

echo "<br><strong>CHUNKS</strong><br>";

//start counting
foreach($chunks as $c){
	echo "".$c." appears " . substr_count($db, $c) . " times.<br>";
}


?>
