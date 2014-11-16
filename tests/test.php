<?php
$files = scandir('./');

$coordinates=array();
$town=array();
$latlng=array();

foreach($files as $file) {
	$f= getCoordinates($file);
	$coordinates[basename($file)]=getCoordinates($file);
}
var_dump($coordinates);


function getCoordinates($jfile)
{
	$coords=array();
	$string .= file_get_contents("./".$jfile); // get json content	
	$json_a = json_decode($string, true); //json decode
	array_push($coords, $json_a['results'][0]['geometry']['location']['lat'],$json_a['results'][0]['geometry']['location']['lng']);
	return $coords;
}


?>
