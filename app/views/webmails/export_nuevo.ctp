<?php
/*
    header("Content-type:application/vnd.ms-excel");
    header("Content-disposition:attachment;filename=webmails.csv");
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
	//obtain the email addresses without <> or other names
	//sender: email address is present in between <> or on its own (without name)
echo $row['Webmail']['sender'];
echo preg_match_all('/(?<=<).*(?=>)/', $row['Webmail']['sender'] , $sender);

	if(preg_match_all('/(?<=<).*(?=>)/', $row['Webmail']['sender'] , $sender) == 0){
		$sender = null;
	}
echo "<pre>";
print_r($sender);
echo "</pre>";

	//receivers: email addresses are present in between <>
	preg_match_all('/(?<=<).*@.*(?=>)/', $row['Webmail']['receivers'] , $receivers);
^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$

echo "<pre>";
print_r($receivers);
echo "</pre>";
	//if an email has several receivers we have to introduce one line per receiver ($idx is to help adding text delimiters)
	$idx = 0;
	foreach($receivers as $receiver){

		// Loop through every value in a row
		foreach ($row['Webmail'] as $key => &$value)
		{
			if($key == "sender"){
				//if sender is null, then $value is the actual address
				if($sender != null)
					$value= $sender[0][0];
		//		$value = str_replace('>', '&gt;', str_replace('<', '&lt;', $value));
			}

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
