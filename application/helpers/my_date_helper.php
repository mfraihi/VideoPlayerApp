<?php
function formatIt($duration, $type){
		$duration = number_format($duration, 0);
		$type = $duration > 1 ? $type . "s" : $type;
		return $duration . " $type ago";
}
	
function RelevantTime($ts){ //converts timestamp to "x days/weeks/months ago" format	
	$result = time() - $ts; //diff between current time and clip create time
	
	if($result >= 60){
		$result /= 60; //to minutes
		if($result >= 60){
			$result /= 60; // to hours
			if($result >= 24){
				$result /= 24; //to days
				if($result >= 7){
					$result /= 7; //to weeks
					if($result >= 4){
						$result /= 4.34; // to months
						if($result >= 12){
							$result /= 12; //to years
							$result = formatIt($result, "year");
						}
						else return formatIt($result, "month");
					}
					else return formatIt($result, "week");
				}
				else return formatIt($result, "day");
			}
			else return formatIt($result, "hour");
		}
		else return formatIt($result, "minute");
	}
	else return formatIt($result, "second");
}

?>