<?php

    header("Content-type:application/vnd.ms-excel");
    header("Content-disposition:attachment;filename=webmails.csv");

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
	//obtain the email addresses without <> or other names
	preg_match_all('/[\\w\\.\\-+=*_]*@[\\w\\.\\-+=*_]*/', $row['Webmail']['sender'] , $sender,PREG_SET_ORDER);
//	preg_match_all('/(?<=<)[\\w\\.\\-+=*_]*@[\\w\\.\\-+=*_]*(?=>)/', $row['Webmail']['receivers'] , $receivers);
	preg_match_all('/(?<=<)[^@]*@[^@>]*(?=>)/', $row['Webmail']['receivers'] , $receivers,PREG_SET_ORDER);
//^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$

	//if an email has several receivers we have to introduce one line per receiver ($idx is to help adding text delimiters)
	$idx = 0;
	foreach($receivers as $receiver){
		// Loop through every value in a row
		foreach ($row['Webmail'] as $key => &$value)
		{
			if($key == "sender"){
				//sender is an array with one array that contains the sender (two dimensions)
				$value= $sender[0][0];
			}
			//receivers is an array of arrays (each array is one receiver)
			else if($key == "receivers"){
				$value= $receiver[0];
			}

		    	//Apply opening and closing text delimiters to every value (only the first time it is read)
			if($idx==0)
				$value = '"'.$value.'"';

		}//foreach ($row['Webmail'] as $key => &$value)

	        // Echo all values in a row comma separated
	        echo implode(";",$row['Webmail'])."\n";

		//update it
		$idx++;

	}//foreach($receivers as $receiver)

    }//foreach ($data as $row)
?>
