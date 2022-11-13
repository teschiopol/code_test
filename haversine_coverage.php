<?php

/** 
  * @author Paolo Concolato
*/

$locations = array(
    array('id'=> 1000, 'zip_code'=> '37069', 'lat'=> 45.35, 'lng'=> 10.84),
    array('id'=> 1001, 'zip_code'=> '37121', 'lat'=> 45.44, 'lng'=> 10.99),
    array('id'=> 1001, 'zip_code'=> '37129', 'lat'=> 45.44, 'lng'=> 11.00),
  	array('id'=> 1001, 'zip_code'=> '37133', 'lat'=> 45.43, 'lng'=> 11.02)
);

$shoppers = array(
    array('id'=> 'S1', 'lat'=> 45.46, 'lng'=> 11.03, 'enabled'=> true),
    array('id'=> 'S2', 'lat'=> 45.46, 'lng'=> 10.12, 'enabled'=> true),
    array('id'=> 'S3', 'lat'=> 45.34, 'lng'=> 10.81, 'enabled'=> true),
    array('id'=> 'S4', 'lat'=> 45.76, 'lng'=> 10.57, 'enabled'=> true),
    array('id'=> 'S5', 'lat'=> 45.34, 'lng'=> 10.63, 'enabled'=> true),
    array('id'=> 'S6', 'lat'=> 45.42, 'lng'=> 10.81, 'enabled'=> true),
    array('id'=> 'S7', 'lat'=> 45.34, 'lng'=> 10.94, 'enabled'=> true),
);

/**
	* 
    * Parse with the standard
    *
    * @param float $lat1 latitude point 1
    * @param float $lng1 longitude point 1
    * @param float $lat2 latitude point 2
    * @param float $lng2 longitude point 2
    * @return int
*/
function haversine($lat1, $lng1, $lat2, $lng2){
	// We use √[(x₂ - x₁)² + (y₂ - y₁)²] instead of haversine formula for a faster calculation in this test
	$t = sqrt(pow($lng2 - $lng1, 2) + pow($lat2 - $lat1,2));
	// convert x100 to obtain km
	$t = ($t*100);
	return (int)$t;
}

$ret = array();
foreach ($shoppers as $key => $value) {
	if($value['enabled']){
		$c = 0;
		$l = 0;
		foreach($locations as $key => $valueL){
			$l++;
			$d = haversine($value['lat'], $value['lng'], $valueL['lat'], $valueL['lng']);
			if ($d < 10){
				$c++;
			}
		}
		$coverage = ($c / $l) * 100;
		$ret[] = array('shopper_id' => $value['id'], 'coverage' => (int)$coverage);
	}
}

/* Sort descending by coverage */
usort($ret, function($a, $b) {
    return $b['coverage'] - $a['coverage'];
});

/* Show result */
print("<pre>".print_r($ret,true)."</pre>");

?>
