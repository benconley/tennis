<?php
	require_once("../inc/sysConfig.inc");

	// setup business logic object
	$tennisDomain = new tennisDomain();
	
	// run competition
	$tennisDomain->execCompetition();
	
	//new dBug($tennisDomain->playerArr);

	//print('<h3>Feedback</h3>');
	//new dBug($tennisDomain->feedbackArr);
	header("Content-Type: application/json", true);
	echo json_encode($tennisDomain->feedbackArr);
?>