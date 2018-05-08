<?php 

require_once __DIR__ . '/vendor/autoload.php';


define('APPLICATION_NAME', 'Calendar');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');

define('SCOPES', implode(' ', array(
Google_Service_Calendar::CALENDAR)
));

date_default_timezone_set('America/New_York');




function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName(APPLICATION_NAME);
    $client->setScopes(SCOPES);
    $client->setAuthConfig(CLIENT_SECRET_PATH);
    $client->setAccessType('offline');

    

    // Load previously authorized credentials from a file.
    $credentialsPath = expandHomeDirectory('credentials.json');
    if (file_exists($credentialsPath)) {
        $accessToken = json_decode(file_get_contents($credentialsPath), true);
    } else {
        // Request authorization from the user.
        if(!credentials_in_browser()){
            $authUrl = $client->createAuthUrl();
            return "<a href='$authUrl' style='margin-left:2px;'>Click here to schedule a time</a>";
        }

        $authCode =$_GET['code'];

        // Exchange authorization code for an access token.
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        // Store the credentials to disk.
        if (!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0700, true);
        }
        file_put_contents($credentialsPath, json_encode($accessToken));
    }
    $client->setAccessToken($accessToken);

    // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()){
        //$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        //file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
        unlink('credentials.json');
        header("Refresh:0; url=http://localhost:8888/Group3.github.io/calendar/");
    }

    return $client;
}





function expandHomeDirectory($path)
{
    $homeDirectory = getenv('HOME');
    if (empty($homeDirectory)) {
        $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
    }
    return str_replace('~', realpath($homeDirectory), $path);
}

function credentials_in_browser(){
    if(isset($_GET['code']))
        return true;
    return false;
}


?>