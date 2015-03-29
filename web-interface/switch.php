<?php
include("../conf/switches.conf.php");
if ($_GET['id']){
echo file_get_contents("http://".$conf['switch_host']."/backend.php?switch=".$_GET['id']);
}

?>
