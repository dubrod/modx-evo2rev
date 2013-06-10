<?php

$data = file_get_contents("modx_site_content.csv");

//update links
$data = str_replace("[~","[[~", $data);
$data = str_replace("~]","]]", $data);

//update chunks
$data = str_replace("{{","[[$", $data);
$data = str_replace("}}","]]", $data);

//update resource tags
$data = str_replace("[*","[[*", $data);
$data = str_replace("*]","]]", $data);

//update placeholders
$data = str_replace("[+","[[+", $data);
$data = str_replace("+]","]]", $data);

//escape single quotes
$data = str_replace("'","\'", $data);

//escape line returns
$data = preg_replace("/[\n\r]/","", $data);

file_put_contents("modx_site_content_updated.csv", $data);


?>