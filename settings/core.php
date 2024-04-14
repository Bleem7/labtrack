<?php

require_once '../vendor/autoload.php';

function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Your Application Name');
    $client->setScopes([Google_Service_Calendar::CALENDAR]);
    $client->setAuthConfig('my-location-311920-abce1ea5e3f7.json');
    $client->setAccessType('offline');

    return $client;
}
?>