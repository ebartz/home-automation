<?php


function garbage_get_dates(){
    
    #load configuration
    require_once("../conf/global.conf.php");
    
    #fetches data from website with dates and returns the dates for the actual month as string with multipple lines
    
    //Base URL to get data from
    $base_url = "http://213.168.213.236/bremereb/bify/bify.jsp?strasse=".$conf['street']."&hausnummer=".$conf['streetNumber']."";
    
    //Load initial Data
    $data = file_get_contents($base_url);
    
    //get intresting data for parsing dates
    $data = preg_match_all('#(<td valign=\'top\'>).*(<\/td>)#eisU', $data, $result);
    
    
    //get actual monthfor german
    $months_german = array(
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
        $key = utf8_encode($key);
        if(strpos(" ".$key, date('Y'))){
            if(strpos(" ".$key, $months_german[date('m')])){
                //replace everything which is not needed
                $key = str_replace("<b>", "", $key);
                $key = str_replace("</b>", "", $key);
                $key = str_replace("<br>", "", $key);
                $key = str_replace("<nobr>", "", $key);
                $key = str_replace("</td>", "", $key);
                $key = str_replace("<td valign='top'>", "", $key);
                $key = str_replace("\t", "", $key);
                $key = str_replace("&nbsp;", " ", $key);
                $key = str_replace("  ", "", $key);
                $key = str_replace($months_german[date('m')]." ".date('Y'), "", $key);
                $key = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $key);
                return trim($key);
            }
        }
    }
}

function garbage_get_next_date(){
    $dates = garbage_get_dates();
    $actual_date = date('d');
    
    foreach(preg_split("/((\r?\n)|(\r\n?))/", $dates) as $line){
    $line_date = substr($line, 0, 2)."\n";
    
    if ($actual_date <= $line_date){
        return $line;
    }
    
    } 
}


?>