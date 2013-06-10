<?php
$mysqli = new mysqli("localhost", "Admin", "PASSWORD", "DB_NAME");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
} else {
   echo "<p>Good Work Bro.</p>";
}
 
$query = "SELECT * FROM modx_site_content";

if ($result = $mysqli->query($query)) {

    /* fetch object array */
    while ($row = $result->fetch_row()) {
        printf ("<p>You have %s (%s) in Site Content</p>\n", $row[0], $row[1]);
    }


    $result->close();
}

//everything connects now lets get down to business

// CSV Function
		function csv_to_array($filename='modx_site_content_updated.csv', $delimiter=',', $enclosure='"')
		{
			if(!file_exists($filename) || !is_readable($filename))
				return FALSE;
			
			$header = NULL;
			$data = array();
			if (($handle = fopen($filename, 'r')) !== FALSE)
			{
				while (($row = fgetcsv($handle, 0, $delimiter, $enclosure)) !== FALSE)
				{
					if(!$header)
						$header = $row;
					else
						$data[] = array_combine($header, $row);
				}
				fclose($handle);
			}
			return $data;
		}

	
//for each row			
foreach(csv_to_array() as $csv_row){
//echo $csv_row[alias];

$insert = "INSERT INTO `modx_site_content` (`id`,`type`,`contentType`,`pagetitle`,`longtitle`,`description`,`alias`,`link_attributes`,`published`,`pub_date`,`unpub_date`,`parent`,`isfolder`,`introtext`,`content`,`richtext`,`template`,`menuindex`,`searchable`,`cacheable`,`createdby`,`createdon`,`editedby`,`editedon`,`deleted`,`deletedon`,`deletedby`,`publishedon`,`publishedby`,`menutitle`,`donthit`,`privateweb`,`privatemgr`,`content_dispo`,`hidemenu`) VALUES ('".$csv_row[id]."','".$csv_row[type]."','".$csv_row[contentType]."','".$csv_row[pagetitle]."','".$csv_row[longtitle]."','".$csv_row[description]."','".$csv_row[alias]."','".$csv_row[link_attributes]."','".$csv_row[published]."','".$csv_row[pub_date]."','".$csv_row[unpub_date]."','".$csv_row[parent]."','".$csv_row[isfolder]."','".$csv_row[introtext]."','".$csv_row[content]."','".$csv_row[richtext]."','".$csv_row[template]."','".$csv_row[menuindex]."','".$csv_row[searchable]."','".$csv_row[cacheable]."','".$csv_row[createdby]."','".$csv_row[createdon]."','".$csv_row[editedby]."','".$csv_row[editedon]."','".$csv_row[deleted]."','".$csv_row[deletedon]."','".$csv_row[deletedby]."','".$csv_row[publishedon]."','".$csv_row[publishedby]."','".$csv_row[menutitle]."','".$csv_row[donthit]."','".$csv_row[privateweb]."','".$csv_row[privatemgr]."','".$csv_row[content_dispo]."','".$csv_row[hidemenu]."')";

$result = $mysqli->query($insert);
	if (!$result) {
	   printf("%s\n", $mysqli->error);
	   exit();
	}

} //eof foreach

$mysqli->close();   
?>