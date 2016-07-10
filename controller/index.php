<?php
require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "751501782006763520-NMcLdqNBfwurxmmidPCnvp4vVZytsiy",
    'oauth_access_token_secret' => "tbG9UNcQes4V0AthMrBYvxR57vCEfxBjKwhku8DKs9zHx",
    'consumer_key' => "n7I8bDFRfG3k6kqyVqtIDYwpR",
    'consumer_secret' => "wGnpQyXL3VlRzeGoOUWZzNAzEfBPdqrxI80yoclBC4yecaP3bB"
);

$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

$requestMethod = "GET";

$getfield = '?screen_name=salesforce&count=1';

$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest(),
             $assoc=true);

// if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
echo "<pre>";
print_r($string);
echo "</pre>";
?>
