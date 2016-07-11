<?php
require_once( $_SERVER['DOCUMENT_ROOT'] .'/Model/TwitterAPIExchange.php');
require_once( $_SERVER['DOCUMENT_ROOT'] .'/Model/Tweet.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "751501782006763520-NMcLdqNBfwurxmmidPCnvp4vVZytsiy",
    'oauth_access_token_secret' => "tbG9UNcQes4V0AthMrBYvxR57vCEfxBjKwhku8DKs9zHx",
    'consumer_key' => "n7I8bDFRfG3k6kqyVqtIDYwpR",
    'consumer_secret' => "wGnpQyXL3VlRzeGoOUWZzNAzEfBPdqrxI80yoclBC4yecaP3bB"
);
$count=3;
$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";
$getfield = '?screen_name=salesforce&count='.$count;

$twitter = new TwitterAPIExchange($settings);
$data = json_decode($twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest(),
             $assoc=true);

// if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
// echo "<pre>";
// print_r($data);
// echo "</pre>";
$arr = array();
foreach($data as $record){
  // echo "<pre>";
  // print_r($record);
  // echo"</pre>";

  $user = $record['user'];
  $name = $user["name"];
  $screen_name = $user["screen_name"];
  $profile_image = $user["profile_image_url"];
  $content = $record["text"];
  $retweet_cnt = $record["retweet_count"];

  $tweet = new Tweet($name, $screen_name, $profile_image, $content, $retweet_cnt);
  array_push($arr, $tweet);
}


// if (count($data->stand)) {
//         // Open the table
//         echo "<table>";
//
//         // Cycle through the array
//         foreach ($data->stand as $idx => $stand) {
//
//             // Output a row
//             echo "<tr>";
//             echo "<td>$stand->afko</td>";
//             echo "<td>$stand->positie</td>";
//             echo "</tr>";
//         }
//
//         // Close the table
//         echo "</table>";
//       }
?>
