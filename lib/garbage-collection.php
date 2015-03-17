<?php


require_once("../conf/global.conf.php");

//echo var_dump($_POST);
error_reporting(0);



//Base URL to get data from
$base_url = "http://213.168.213.236/bremereb/bify/bify.jsp?strasse=".$conf['street']."&hausnummer=".$conf['streetNumber']."";




//Load initial Data
$data = file_get_contents($base_url);


$data = str_replace("</h3>", "</h4>", $data);


//get intresting data for parsing dates
$data = preg_match_all('#(<td valign=\'top\'>).*(<\/td>)#eisU', $data, $result);

//echo var_dump($result[0]);

//echo $result[0][1];
//search for actual month
foreach($result[0] as $key){
    
    echo $key;
}


?>