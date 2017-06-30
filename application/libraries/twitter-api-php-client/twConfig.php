<?php
if(!session_id()){
    session_start();
}

//Include Twitter client library 
include_once 'src/twitteroauth.php';

/*
 * Configuration and setup Twitter API
 */
$consumerKey = 'InsertYourConsumerKey';
$consumerSecret = 'InsertYourConsumerSecret';
$redirectURL = 'http://localhost/twitter_login_php/';

?>