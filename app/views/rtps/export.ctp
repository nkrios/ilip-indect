<?php

    header("Content-type:application/vnd.ms-excel");
    header("Content-disposition:attachment;filename=rtps.csv");
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
	// Loop through every value in a row
        foreach ($row['Rtp'] as $key => &$value)
        {
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
        echo implode(";",$row['Rtp'])."\n";
    }
?>
