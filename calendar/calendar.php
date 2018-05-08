<?php 
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	require_once('./connection.php');
$the_html = $_GET['action']();

echo $the_html;
}
else{
	echo "failed";
	die();
}

function get_times(){

	$date = new DateTime($_GET['date']);
	$day_after = new DateTime($_GET['date']);
	$day_after->add(new DateInterval('P1D'));
	$innerHTML = [];
	for($i=0; $i<24; $i++){
		$innerHTML_arr[] = "<option value = '$i'>$i:00</option>";
	}




	$client = getClient();
	$service = new Google_Service_Calendar($client);
	$calendarId = '07qu68hvb57ptqkn8vk5c1j8l0@group.calendar.google.com';



	$optParams = array(

		'timeMin' => date('c', $date->getTimestamp()),
		'timeMax' => date('c', $day_after->getTimestamp()),
	);
	$results = $service->events->listEvents($calendarId, $optParams);

	$the_html="";
	foreach ($results->getItems() as $event){
		$s = new DateTime($event->start->dateTime);
		$start = date('G', $s->getTimestamp());
		unset($innerHTML_arr[$start]);
	}
	$the_html.=implode("", $innerHTML_arr);

	return $the_html;


}




function delete_me(){
	$client = getClient();
	$service = new Google_Service_Calendar($client);
	$del=$_GET['del_id'];
	$service->events->delete('07qu68hvb57ptqkn8vk5c1j8l0@group.calendar.google.com', $del);
	$the_html="Deleted!";
	return $the_html;
}


function createEvent(){
	$date_time = new DateTime($_GET['date']);
	$date_time->setTime($_GET['time'], 0);
	$end_date_time = new DateTime($_GET['date']);
	$end_date_time->setTime($_GET['time']+1, 0);


	$client = getClient();

	$service = new Google_Service_Calendar($client);
	$event = new Google_Service_Calendar_Event(array(
		'summary' => "Cleaner Schedule",
		'location' => "CUSP",
		'description' => "Clean the room",

		'start' => array(
			'dateTime' => date('c', $date_time->getTimestamp()),
			'timeZone' => 'America/New_York',
			
		),
		'end' => array(
		'dateTime' => date('c', $end_date_time->getTimestamp()),
		'timeZone' => 'America/New_York',
	),
		
		

		'guestsCanInviteOthers' => FALSE,
		'visibility' => "private",
		'reminders' => array(
			'useDefault' => FALSE,
			'overrides' => array(
				array('method' => 'email', 'minutes' => 24*60),
				array('method' => 'popup', 'minutes' => 10),
			),
		),
	));

	$params=["sendNotifications" => "true"];
	$calendarId='07qu68hvb57ptqkn8vk5c1j8l0@group.calendar.google.com';
	$event = $service->events->insert($calendarId, $event, $params);


	$the_html="Scheduled! Your event id is shown below, please keep it for deletion: $event->id";
	return $the_html;
}



 ?>