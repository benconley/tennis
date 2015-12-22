<?php
// start class tennisDomain
class tennisDomain {
public $dataArr = [];
public $playerArr = [];
public $feedbackArr = [];
public $competitionArr = [];
public $compWinnerFound = false;
public $returnMissed = false;
public $matchPointCtr = 0;
public $matchServer;
public $matchReceiver;
public $volleyServer;
public $volleyReceiver;
public $origPlayerA;
public $origPlayerB;
// max number of competitions each
public $numMatches = 1;

public function execCompetition() {
	// get data
	$tennisDAO = new tennisDAO();
	$this->dataArr = $tennisDAO->getData();

	// get player array
	$this->setupPlayerArr($this->dataArr);

	// execute matches for each of the players
	// make this a while loop that looks for a winner	
	foreach ($this->playerArr as $playerA) {
		$this->competitionArr[$playerA['name']] = array();
		// find competitors
		foreach ($this->playerArr as $playerB) {
			// competitors obviously can't play themselves
			if ($playerA['name'] != $playerB['name'] ) {
				if ( !isset($this->competitionArr[$playerA['name']][$playerB['name']]) ) {
					$this->competitionArr[$playerB['name']][$playerA['name']] = 0;
				}
				if ( !isset($this->competitionArr[$playerB['name']][$playerA['name']]) ) {
					$this->competitionArr[$playerB['name']][$playerA['name']] = 0;
				}
				// competitors should not play each other more than once
				// There is some sort of bug in the number of matches being played. That's why I added the double indexing, but it didn't resolve the issue. Needs troubleshooting
				if ( $this->competitionArr[$playerA['name']][$playerB['name']] < $this->numMatches && $this->competitionArr[$playerB['name']][$playerA['name']] < $this->numMatches) {
					$this->executeMatch($playerA['name'], $playerB['name']);
					$this->competitionArr[$playerA['name']][$playerB['name']]++;
					$this->competitionArr[$playerB['name']][$playerA['name']]++;
				}
			}
		}
	}
	//new dBug($this->competitionArr);
}

// configure simple array for storing player scoring info
public function setupPlayerArr($dataArr=[]) {
	
	// give each player an entry
	foreach ($dataArr as $player) {
		$this->playerArr[ $player['name'] ] = array();
		$this->playerArr[ $player['name'] ]['name'] = $player['name'];
		$this->playerArr[ $player['name'] ]['serve_accuracy'] = $player['serve_accuracy'];
		$this->playerArr[ $player['name'] ]['serve_spin'] = $player['serve_spin'];
		$this->playerArr[ $player['name'] ]['return_skill'] = $player['return_skill'];
		$this->playerArr[ $player['name'] ]['return_accuracy'] = $player['return_accuracy'];
		$this->playerArr[ $player['name'] ]['return_spin'] = $player['return_spin'];
		$this->playerArr[ $player['name'] ]['score'] = 0;
		$this->playerArr[ $player['name'] ]['wins'] = 0;
		$this->playerArr[ $player['name'] ]['losses'] = 0;
	}

}

// execute match between two players
public function executeMatch($playerA, $playerB) {
	// log new match
	array_push($this->feedbackArr, '<h3>New Match:</h3> ' . $playerA . ' vs ' . $playerB);

	// reset point counts
	$this->matchPointCtr = 0;
	$this->matchServer = $playerA;
	$this->matchReceiver = $playerB;
	$this->origPlayerA = $playerA;
	$this->origPlayerB = $playerB;
	$this->playerArr[ $playerA ]['score'] = 0;
	$this->playerArr[ $playerB ]['score'] = 0;

	// 
	while ($this->playerArr[ $playerA ]['score'] < 11 && $this->playerArr[ $playerB ]['score'] < 11) {
		// switch serve every two points
		if ($this->matchPointCtr == 2) {
			$this->switchServer();
		}

		$this->executeServe($this->matchServer, $this->matchReceiver);
	}

	// declare a winner
	if ( $this->playerArr[ $playerA ]['score'] == 11 ) {
		$this->playerArr[ $playerA ]['wins'] += 1;
		$this->playerArr[ $playerB ]['losses'] += 1;
		array_push($this->feedbackArr, '<strong>' . $playerA . ' wins the game!</strong>');
	} else {
		$this->playerArr[ $playerB ]['wins'] += 1;
		$this->playerArr[ $playerA ]['losses'] += 1;
		array_push($this->feedbackArr, '<strong>' . $playerB . ' wins the game!</strong>');
	}
	array_push($this->feedbackArr, $playerA . '\'s record is now ' . $this->playerArr[ $playerA ]['wins'] . ' - ' . $this->playerArr[ $playerA ]['losses']);
	array_push($this->feedbackArr, $playerB . '\'s record is now ' . $this->playerArr[ $playerB ]['wins'] . ' - ' . $this->playerArr[ $playerB ]['losses']);
	array_push($this->feedbackArr, '<br>');
}

// execute serve between two players
public function executeServe($playerA, $playerB) {
	// log new serve
	$feedbackLine = $playerA . ' serves to ' . $playerB . '...';

	$this->volleyServer = $playerA;
	$this->volleyReceiver = $playerB;
	// in bounds if serve_accuracy exceeds random percentile
	$inBounds = $this->playerArr[ $playerA ]['serve_accuracy'] > rand(0, 100);
	// serve in bounds
	if ($inBounds) {
		$feedbackLine .= ' in bounds';
		array_push($this->feedbackArr, $feedbackLine);

		// check for exchange and execute until someone misses
		$this->returnMissed = false;
		while ( !$this->returnMissed ) {
			$this->checkReturn();
			// swap recipient if no one missed
			if ( !$this->returnMissed) {
				$this->switchReceiver();
			}
		}
		// points can only be scored by the server
		if ( $this->matchServer == $playerA && $this->volleyReceiver != $playerA) {
			array_push($this->feedbackArr, $playerA . ' scores a point!');
			$this->playerArr[ $playerA ]['score'] += 1;
			array_push($this->feedbackArr, 'The score is now ' . $this->origPlayerA . ': ' . $this->playerArr[ $this->origPlayerA ]['score'] . ', ' . $this->origPlayerB . ': ' . $this->playerArr[ $this->origPlayerB ]['score']);
			$this->matchPointCtr++;
		}
		

	// serve out of bounds
	} else {
		$feedbackLine .= ' out of bounds';
		array_push($this->feedbackArr, $feedbackLine);

		array_push($this->feedbackArr, $playerB . ' scores a point!');		
		$this->playerArr[ $playerB ]['score'] += 1;
		array_push($this->feedbackArr, 'The score is now' . $this->origPlayerA . ': ' . $this->playerArr[ $this->origPlayerA ]['score'] . ', ' . $this->origPlayerB . ': ' . $this->playerArr[ $this->origPlayerB ]['score']);
		$this->matchPointCtr++;
	}

}

// check for return
public function checkReturn() {
	// check for failed return
	if ( $this->playerArr[ $this->volleyReceiver ]['return_skill'] < rand(0, 100) ) {
		array_push($this->feedbackArr, $this->volleyReceiver . ' was unable to return');
		$this->returnMissed = true;
	// handle a successful return
	} else {
		// check for out of bounds return
		if ( $this->playerArr[ $this->volleyReceiver ]['return_accuracy'] < rand(0, 100) ) {
			array_push($this->feedbackArr, $this->volleyReceiver . ' successfully returned, but it was out of bounds');
			$this->returnMissed = true;
		// return was successful
		} else {
			array_push($this->feedbackArr, $this->volleyReceiver . ' returns to ' . $this->volleyServer. '... in bounds');
		}
	}
}
// switch server
public function switchServer() {
	// switch them
	$origReceiver = $this->matchReceiver;
	$this->matchReceiver = $this->matchServer;
	$this->matchServer = $origReceiver;

	// reset point counter
	$this->matchPointCtr = 0;
}

// switch receiver
public function switchReceiver() {
	// switch them
	$origReceiver = $this->volleyReceiver;
	$this->volleyReceiver = $this->volleyServer;
	$this->volleyServer = $origReceiver;
}

// end class tennisDomain	
}
?>