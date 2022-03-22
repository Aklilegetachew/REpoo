<?php
		
	function twopoints_on_earth($latitudeFrom, $longitudeFrom,$latitudeTo, $longitudeTo)
	{
		$long1 = deg2rad($longitudeFrom);
		$long2 = deg2rad($longitudeTo);
		$lat1 = deg2rad($latitudeFrom);
		$lat2 = deg2rad($latitudeTo);
			
		//Haversine Formula
		$dlong = $long2 - $long1;
		$dlati = $lat2 - $lat1;
			
		$val = pow(sin($dlati/2),2)+cos($lat1)*cos($lat2)*pow(sin($dlong/2),2);
			
		$res = 2 * asin(sqrt($val));
			
		$radius = 3958.756;
			
		return ($res*$radius);
	}

	// latitude and longitude of Two Points
	// $latitudeFrom = 19.017656 ;
	// $longitudeFrom = 72.856178;
	// $latitudeTo = 40.7127;
	// $longitudeTo = -74.0059;
		
	// Distance between Mumbai and New York
	// print_r(twopoints_on_earth( $latitudeFrom, $longitudeFrom,
	// 				$latitudeTo, $longitudeTo).' '.'miles');


