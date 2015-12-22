<?php
class tennisDAO {
public $dataFile = '../data/data.csv';

public function getData() {
	/*
		This should be driven by some sort of persistent scope to avoid loading unless necessary
	*/
	$csv = $this->csv_to_array($this->dataFile);
	return $csv;		
}
	
public function csv_to_array($filename='', $delimiter=',') {
	if(!file_exists($filename) || !is_readable($filename)) {
		return NULL;
	}
	$header = NULL;
	$data = array();
	if (($handle = fopen($filename, 'r')) !== FALSE) {
		while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
			if(!$header) {
				$header = $row;
			} else {
				$data[] = array_combine($header, $row);
			}
		}
		fclose($handle);
	}
	return $data;

	}
	
}
?>