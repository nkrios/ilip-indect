<?php 

function unicode2html($string) {
    return preg_replace('/\\\\u([0-9a-z]{4})/', '&#x$1;', $string);
}

echo '<h1>'.unicode2html($user)."   /   ".unicode2html($friend)."  (".$ct.")".'</h1>'; 
echo $chat;


?>