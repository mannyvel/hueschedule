<?php

include_once 'vendor/autoload.php'; // Path to autoload.php file.

/*
	This little script will set the alarm time for any alarm with a description
	containing "Porch" to 10 minutes after sunset.
*/
// set time to your time zone
date_default_timezone_set("America/Los_Angeles");

// get DST
$dst = date('I'); // this will be 1 in DST or else 0

// get sunset
//$sunset = date_sunset(time(), SUNFUNCS_RET_STRING, 45.52, -122.65, 90, $dst ? -7 : -8);

// set your location too

$sunset = date_sunset(time(), SUNFUNCS_RET_TIMESTAMP, 45.52, -122.65, 90, $dst ? -7 : -8);

// offset by 10 minutes

$sunset_time = date("H:i", $sunset + 600);
$sunset = $sunset_time;

// change localtime everything after T
// change description containing "Porch"

// There are instructions on how to obtain Hostname and Username below.
$bridge_hostname = 'BRIDGE_IP';
$bridge_username = 'BRIDER_USERNAME';

$hue = new \AlphaHue\AlphaHue($bridge_hostname, $bridge_username);

$schedules = $hue->getSchedules();
$index = 0;
$keys = array_keys($schedules);
foreach ($schedules as $oneSchedule)
{
	$desc = $oneSchedule[description];
	
	if (strpos($desc, 'Porch') !== false)
	{
		$theTime = $oneSchedule[localtime];
		$oldTime = explode("T", $theTime);
		$newTime = $oldTime[0] ."T" . $sunset . ":00";
		$id = $keys[$index];
//		print_r($oneSchedule);
//		print $keys[$index] . "\n";
		$hue->updateScheduleTime($id, $newTime);
	}
	$index++;
}
//print_r($schedules);
?>