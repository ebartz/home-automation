<?php
include("../conf/switches.conf.php");
echo file_get_contents("http://".$conf['switch_host']."/status.php?switch=".$_GET['switch']);
?>
