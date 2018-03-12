<?php

require_once('connection.php');

function elapsed_time($student_id)
{
		global $db;

		function isWeekend($date) {
			return (date('N', strtotime($date)) >= 6);
		}


		$lastEventTimeQuery = $db->query("SELECT timestamp FROM history WHERE student_id = '$student_id' ORDER BY event_id DESC LIMIT 1");
		$time1 = new DateTime($lastEventTimeQuery->fetch_array()[0]); // last event in the history table
		if (isWeekend($time1->format('Y-m-d'))) {
			return 0;
		}
		$holQuery = $db->query("SELECT COUNT(*) FROM holidays WHERE holiday_date =" . $time1->format('Y-m-d'));
		if ($holQuery->fetch_array()[0] != 0) {
			return 0;
		}

		$time2 = new DateTime();

		$start = new DateTime($time1->format('Y-m-d' . '9:00'));
		$end = new DateTime($time1->format('Y-m-d' . '15:40'));
		//is event 1 before the start of the school day of the same day?
		if ($time1 < $start){
				$time1 = $start;
		}
				//is event 2 after the end of the school day of the same day of event 1?
		if ($time2 > $end){
				$time2 = $end;
		}
		$time_elapsed = round(($time2->getTimestamp()-$time1->getTimestamp())/60, 2);
		if ($time_elapsed < 0) {
				$time_elapsed = 0;
		}
		return $time_elapsed;
}
function status_update($student, $status, $old_status, $info = '', $return_time = '')
{
	global $db;
  // Update current table with new event
	$query = 'UPDATE current SET status_id = '.$status.' WHERE student_id = '.$student;
	$db->query($query);
	$elapsed = elapsed_time($student);
  $query = "UPDATE history SET elapsed = '$elapsed' WHERE student_id = '$student' ORDER BY event_id DESC LIMIT 1";
  $db->query($query);


  // TODO
	// If old status is offsite, not checked in, absent, or late? Or do it for all events?
	// UPDATE immediate prior record in history table for student’s immediate prior event with calculated duration

	// First: SELECT the timestamp AND event_ID from the last event for the $student
	// Second: Compute the elapsed time from that last event until now
	// Third: UPDATE the elapsed time (in decmial hours? minutes?) into the event_ID line of the history table

	// Add new event to history table
  $query_insert = 'INSERT INTO history (student_id, status_id) VALUES ('.$student.', '.$status.')';
	$db->query($query_insert);

  return 0;
}
function enquote($text){
	return '"'.$text.'"';
}
?>
