<?php



function switches_get_rooms(){
	#function will return an array of available rooms which are configured in the switches config

	require_once("../conf/switches.conf.php");

	$room_names = array();

	foreach($switches as $switch){
		if (!array_search($switch["room"], $room_names)){
			array_push($room_names, $switch["room"]);
		}
	}

	return $room_names;

}

function switches_get_switches_by_room($room_name){
	#function will return an array of available switches for the given room name

	require_once("../conf/switches.conf.php");

        $result_switches = array();

        foreach($switches as $switch){
                if ($switch["room"] == $room_name){
                        array_push($result_switches, $switch);
                }
        }

        return $result_switches;
}

function switches_get_switches(){
	#function returns all available switches

	require_once("../conf/switches.conf.php");

	return $switches;
}

?>
