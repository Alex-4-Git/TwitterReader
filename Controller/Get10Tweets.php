<?php
require_once( $_SERVER['DOCUMENT_ROOT'] .'/Model/TwitterAPIExchange.php');
require_once( $_SERVER['DOCUMENT_ROOT'] .'/Model/Tweet.php');


$settings = array(
    'oauth_access_token' => "751501782006763520-NMcLdqNBfwurxmmidPCnvp4vVZytsiy",
    'oauth_access_token_secret' => "tbG9UNcQes4V0AthMrBYvxR57vCEfxBjKwhku8DKs9zHx",
    'consumer_key' => "n7I8bDFRfG3k6kqyVqtIDYwpR",
    'consumer_secret' => "wGnpQyXL3VlRzeGoOUWZzNAzEfBPdqrxI80yoclBC4yecaP3bB"
);


$count=10;
$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";
$getfield = '?screen_name=CNN&count='.$count;

$twitter = new TwitterAPIExchange($settings);
$data = json_decode($twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest(),
             $assoc=true);
$arr = array();
foreach($data as $record){

  $user = $record['user'];
  $name = $user["name"];
  $screen_name = $user["screen_name"];
  $profile_image = $user["profile_image_url"];
  $content = $record["text"];
  $retweet_cnt = $record["retweet_count"];
  $tweet = array("name"=>$user["name"],
                  "screen_name"=>$user["screen_name"],
                  "profile_image"=>"<img src='".$user["profile_image_url"]."'>",
                  "content"=> $record["text"],
                  "retweet_cnt" => $record["retweet_count"]);

  array_push($arr, $tweet);
}
?>

<!doctype html>
  <head>
    <link rel="stylesheet" href="../View/mycss.css" type="text/css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script>
      var freshFlag=true;
      $("document").ready(function autoFresh(){
          setTimeout(function(){
            if(freshFlag){
              $("#autoRefresh").submit();
            }else{
              console.log("Stop updating");
            }
          }, 15000);
      });

      $(function(){
        $("#searchBar").click(function(){
            freshFlag=false;
            console.log(typeof filter);
            filter();
          });
      });

      function filter(){
        $(function(){
          var inputtext = $("#searchInput").val();
          var data = inputtext.split(" ");
          //create a jquery object of the rows
          var jo = $("#fbody").find("tr");
          if (inputtext == "") {
              jo.show();
              return;
          }
          //hide all the rows
          jo.hide();

          //Recusively filter the jquery object to get results.
          jo.filter(function (i, v) {
              var $t = $(this);
              for (var d = 0; d < data.length; ++d) {
                  if ($t.is(":contains('" + data[d] + "')")) {
                      return true;
                  }
              }
              return false;
          })
          //show the rows that match.
          .show();
        });
      }

      // $(function(){
      //   $("#searchBar").click(function(){
      //     if(!freshFlag){
      //       $("#autoRefresh").submit();
      //       console.log("start updating");
      //     }
      //     });
      // });
      //
      // $(function(){
      //   $("#searchInput").keyup(function () {
      //     //split the current value of searchInput
      //     freshFlag=false;
      //     var data = this.value.split(" ");
      //     if(data==""){
      //       $("#autoRefresh").submit();
      //     }
      //     // console.log(data);
      //     // console.log("stop updating");
      //     //create a jquery object of the rows
      //     var jo = $("#fbody").find("tr");
      //     if (this.value == "") {
      //         jo.show();
      //         return;
      //     }
      //     //hide all the rows
      //     jo.hide();

          //Recusively filter the jquery object to get results.
      //     jo.filter(function (i, v) {
      //         var $t = $(this);
      //         for (var d = 0; d < data.length; ++d) {
      //             if ($t.is(":contains('" + data[d] + "')")) {
      //                 return true;
      //             }
      //         }
      //         return false;
      //     })
      //     //show the rows that match.
      //     .show();
      //   });
      // });



    </script>
  </head>

  <body>
    <input type="text" id="searchInput">
    <button id="searchBar"> Search </button>
    <br/>
    <br/>
    <form id="autoRefresh" action="Get10Tweets.php" method="post">
    </from>

    <table id="tweet_table">
      <?php if(count($arr)>0): ?>
          <thead>
            <tr>
              <th><?php echo implode('</th><th>', array_keys(current($arr))); ?></th>
            </tr>
          </thead>
          <tbody id="fbody">
            <?php foreach ($arr as $row): array_map('htmlentities', $row); ?>
              <tr>
                <td><?php echo implode('</td><td>', $row); ?></td>
              </tr>
          <?php endforeach; ?>
          </tbody>
      <?php endif; ?>
    </table>
  </body>

</html>
