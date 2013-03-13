<?php

    header("Content-type:application/vnd.ms-excel");
    header("Content-disposition:attachment;filename=sips.csv");
/*
echo "<pre>";
print_r($data);
echo "</pre>";
*/
    // Loop through every value in a row
    foreach ($headers as &$value)
    {
	// Apply opening and closing text delimiters to every value
	$value = '"'.$value.'"';
    }
    echo implode(";",$headers)."\n";

    // Loop through the data array
    foreach ($data as $row)
    {
	//obtain the sip addresses without <> or other names
	preg_match_all('/(?<=<sip:).*(?=>)/', $row['Sip']['from_addr'] , $sender);
	//there's one receiver only
	preg_match_all('/(?<=<sip:).*(?=>)/', $row['Sip']['to_addr'] , $receiver);

	// Loop through every value in a row
        foreach ($row['Sip'] as $key => &$value)
        {
		if($key == "from_addr"){
			$value= $sender[0][0];
		}

		else if($key == "to_addr"){
			$value= $receiver[0][0];
		}

	   if($key == "capture_date"){
		$date = new DateTime($value);
	    }
	   //when duration is found, substitute it for the time
	   if($key == "duration"){
		$date->add(new DateInterval('PT'.$value.'S'));
		$value = $date->format('Y-m-d H:i:s');
	    }
            // Apply opening and closing text delimiters to every value
           $value = '"'.$value.'"';
        }
        // Echo all values in a row comma separated
        echo implode(";",$row['Sip'])."\n";
    }
?>
