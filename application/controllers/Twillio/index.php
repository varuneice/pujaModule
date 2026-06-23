<?php
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/../../config/env.php';
use Twilio\Rest\Client;

$client = new Client($ENV_TWILIO_SID, $ENV_TWILIO_TOKEN);



//$twilio_number = "+15017122661";


$message = $client->messages->create(
    // Where to send a text message (your cell phone?)
    '+917017618292',
    array(
        'from' => '+18592377620',
        'body' => 'hi londo msg aa gaya '
    )
);

   if($message){
	   echo 'hey';
   }else{
	   echo 'kuch ni';
   }

?>