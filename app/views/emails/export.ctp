<?php
/*
    header("Content-type:application/vnd.ms-excel");
    header("Content-disposition:attachment;filename=emails.csv");
*/
print_r($data);
    // Loop through every value in a row
    foreach ($headers as &$value){
		// Apply opening and closing text delimiters to every value
		$value = '"'.$value.'"';
    }
    echo implode(";",$headers)."\n";

    // Loop through the data array
    foreach ($data as $row){
	//obtain the email addresses without <> or other names
	preg_match_all('/[\\w\\.\\-+=*_]*@[\\w\\.\\-+=*_]*/', $row['Email']['sender'] , $sender);
	preg_match_all('/(?<=<)[\\w\\.\\-+=*_]*@[\\w\\.\\-+=*_]*(?=>)/', $row['Email']['receivers'] , $receivers,PREG_SET_ORDER);

	//if an email has several receivers we have to introduce one line per receiver ($idx is to help adding text delimiters)
	$idx = 0;
	foreach($receivers as $receiver){
		// Loop through every value in a row
		foreach ($row['Email'] as $key => &$value){
			if($key == "sender"){
				$value= $sender[0][0];
		//		$value = str_replace('>', '&gt;', str_replace('<', '&lt;', $value));
			}

			else if($key == "receivers"){
				$value= $receiver[0];
			}

		    	//Apply opening and closing text delimiters to every value (only the first time it is read)
			if($idx==0)
				$value = '"'.$value.'"';

		}//foreach ($row['Email'] as $key => &$value)

	        // Echo all values in a row comma separated
	        echo implode(";",$row['Email'])."\n";

		//update it
		$idx++;

	}//foreach($receivers as $receiver)
    }//foreach ($data as $row)
?>
