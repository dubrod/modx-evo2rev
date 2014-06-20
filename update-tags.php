<?php

$data = file_get_contents("modx_site_content.csv");

//update site url - [(site_url)]
$data = str_replace("[(site_url)]","[[++site_url]]", $data);

//update site name - [(site_name)]
$data = str_replace("[(site_name)]","[[++site_name]]", $data);

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

//update non-cached
$data = str_replace("[!","[[!", $data);
$data = str_replace("!]","]]", $data);

//escape single quotes
$data = str_replace("'","\'", $data);

//escape line returns
$data = preg_replace("/[\n\r]/","", $data);

file_put_contents("modx_site_content_updated.csv", $data);


?>
