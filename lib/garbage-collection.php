<?php
error_reporting(0);

function garbage_get_dates(){
    //function will return the dates for the actual and the next month

    //create empty result variable
    $result_dates;
    #load configuration
    require_once("../conf/global.conf.php");
    
    #fetches data from website with dates and returns the dates for the actual month as string with multipple lines
    
    //Base URL to get data from
    $base_url = "http://213.168.213.236/bremereb/bify/bify.jsp?strasse=".$conf['street']."&hausnummer=".$conf['streetNumber']."";
    
    //Load initial Data
    $data = file_get_contents($base_url);
    
    //get intresting data for parsing dates
    $data = preg_match_all('#(<td valign=\'top\'>).*(<\/td>)#eisU', $data, $result);
    
    
    //get actual month for german
    $months_german = array(
                           "1"  => "Januar",
                           "2"  => "Februar",
                           "3"  => "März",
                           "4"  => "April",
                           "5"  => "Mai",
                           "6"  => "Juni",
                           "7"  => "Juli",
                           "8"  => "August",
                           "9"  => "September",
                           "01" => "Januar",
                           "02" => "Februar",
                           "03" => "März",
                           "04" => "April",
                           "05" => "Mai",
                           "06" => "Juni",
                           "07" => "Juli",
                           "08" => "August",
                           "09" => "September",
                           "10" => "Oktober",
                           "11" => "November",
                           "12" => "Dezember");
    
    //search for actual month
    foreach($result[0] as $key){
        //ensure the encoding is good
        $key = utf8_encode($key);
        //get the results for the actual year
        if(strpos(" ".$key, date('Y'))){
            //filter the dates for the actual and the next month
            if(strpos(" ".$key, $months_german[date('m')]) || strpos(" ".$key, $months_german[(date('m') +1)]) ){
                
                $result_dates = $key;
            }
        }
    }
  //replace everything which is not needed
  $result_dates = str_replace("<b>", "", $result_dates);
  $result_dates = str_replace("</b>", "", $result_dates);
  $result_dates = str_replace("<br>", "", $result_dates);
  $result_dates = str_replace("<nobr>", "", $result_dates);
  $result_dates = str_replace("</td>", "", $result_dates);
  $result_dates = str_replace("<td valign='top'>", "", $result_dates);
  $result_dates = str_replace("\t", "", $result_dates);
  $result_dates = str_replace("&nbsp;", " ", $result_dates);
  $result_dates = str_replace("  ", "", $result_dates);
  $result_dates = str_replace($months_german[date('m')]." ".date('Y'), "", $result_dates);
  $result_dates = str_replace($months_german[(date('m') +1)]." ".date('Y'), "", $result_dates);
  $result_dates = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $result_dates);
  //return the usable result
  return trim($result_dates);
}

function garbage_get_next_date(){
    // Function will return the next date of the garage collection according to the actual date of the server
    $dates = garbage_get_dates();
    $actual_date = date('d');
    
    foreach(preg_split("/((\r?\n)|(\r\n?))/", $dates) as $line){
    $line_date = substr($line, 0, 2)."\n";
    
    if ($actual_date <= $line_date){
        return $line;
    }
    
    } 
}


echo garbage_get_dates();


?>