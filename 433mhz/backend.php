<?php


require("../conf/switches.conf.php");

//echo var_dump($switches);

$switch=$_GET['switch'];

$status_path = "/var/www/switch/";
$switch_file = $status_path.$switch;


function switchSend ($switchid, $command, $switches){
  // Function will send the 433 mhz code for the switch using the little cpp program called codesend
  echo $command;
  if ($command == "0"){
  return shell_exec("/usr/bin/sudo /bin/codesend ".$switches[$switchid]["Off"]);
  }
  if ($command == "1"){
  return shell_exec("/usr/bin/sudo /bin/codesend ".$switches[$switchid]["On"]);
  }
}

// This will toggle the switch every time it is loaded if there is no specific command command given. If it's given it will just execute the on or off command. It will also store the actual status to a file so the status will be available if the host has been rebooted.
if ( !isset($_GET['cmd']) ){
  if (file_exists($switch_file)){
    if (file_get_contents($switch_file) == "0"){
      file_put_contents($switch_file, "1");
      switchSend($switch, "1", $switches);
      return;
    }
    if (file_get_contents($switch_file) == "1"){
      file_put_contents($switch_file, "0");
      switchSend($switch, "0", $switches);
      return;
    }

  }else{
    file_put_contents($switch_file, "1");
    switchSend($switch, "1", $switches);
  }
}else{
  if ($_GET['cmd'] == 1){
    file_put_contents($switch_file, "1");
    switchSend($switch, "1", $switches);
  }
  if ($_GET['cmd'] == 0){
    file_put_contents($switch_file, "0");
    switchSend($switch, "0", $switches);
  }
}

?>
