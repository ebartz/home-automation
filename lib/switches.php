<?php



function switches_get_rooms(){
	#function will return an array of available rooms which are configured in the switches config

	require("../conf/switches.conf.php");

	$room_names = array();

	foreach($switches as $switch){
		if ( array_search($switch["room"], $room_names) === false){
			array_push($room_names, $switch["room"]);
		}
	}

	return $room_names;

}

function switches_get_switches_by_room($room_name){
	#function will return an array of available switches for the given room name

	require("../conf/switches.conf.php");

        $result_switches = array();

        foreach($switches as $switch){
                if ($switch["room"] == $room_name){
                        array_push($result_switches, $switch);
                }
        }

        return $result_switches;
}

function switches_get_switches_by_id($switch_id){
	#function will return an array of witch the data of the given switch id

	require("../conf/switches.conf.php");

        foreach($switches as $switch){
                if ($switch["id"] == $switch_id){
                        $result_switch = $switch;
                }
        }

        return $result_switch;
}

function switches_get_switches(){
	#function returns all available switches

	require("../conf/switches.conf.php");

	return $switches;
}

?>
