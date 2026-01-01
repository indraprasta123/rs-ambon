<?php
//sessoin_start();
include_once '../sw-library/sw-config.php';
// Include Librari Google Client (API)
include_once '../sw-library/google-client/Google_Client.php';
include_once '../sw-library/google-client/contrib/Google_Oauth2Service.php';

$client_id = '6Lf_v8cjAAAAAKbyHJi4lRPemjRb6yo73vChH1ev'; // Google client ID
$client_secret = '6Lf_v8cjAAAAAHL0jTOLe_6pnkDtqqmg-tPgz8XY'; // Google Client Secret
$redirect_url = ''.$site_url.'/oauth/google'; // Callback URL

// Call Google API
$gclient = new Google_Client();
$gclient->setClientId($client_id); // Set dengan Client ID
$gclient->setClientSecret($client_secret); // Set dengan Client Secret
$gclient->setRedirectUri($redirect_url); // Set URL untuk Redirect setelah berhasil login

$google_oauthv2 = new Google_Oauth2Service($gclient);
?>
