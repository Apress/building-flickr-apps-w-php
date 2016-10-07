<?php
include_once 'Phlickr/Api.php';

// Prevent from enforcing a time limit on this script
set_time_limit(0);

print "This script will help you retrieve a Flickr authorization token.\n\n";

// Get the user's API key and secret.
print 'API Key: ';
$api_key = trim(fgets(STDIN));
print 'API Secret: ';
$api_secret = trim(fgets(STDIN));

// Create an API object, then request a frob.
$api = new Phlickr_Api($api_key, $api_secret);
$frob = $api->requestFrob();
print "Got a frob: $frob\n";

// Find out the desired permissions.
print 'Permissions (read, write, or delete): ';
$perms = trim(fgets(STDIN));

// Build the authentication URL.
$url = $api->buildAuthUrl($perms, $frob);
print "\nOpen the following URL and authorize:\n$url\n";
print "\nPress Return when you're finished...\n";
fgets(STDIN);

// After they've granted permission, convert the frob to a token.
$token = $api->setAuthTokenFromFrob($frob);

// Print out the token.
print "Auth token: $token\n";
?>
