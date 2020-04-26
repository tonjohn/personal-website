<?php

$pw = "spuf";
$sPassword = "";

if(isset($_GET['pw'])){
  $sPassword = $_GET['pw'];
}

if(empty($sPassword) || $sPassword != $pw )
{
  die("For Science, You Monster");
}


/*
## FUN FACTS

"Burton ran the #1 competitive clan and server"
"Burton originally wanted to be CPU architect before changing his major to Computer Science"
"Senior year in highschool, Burton stared in the musical Once Upon a Mattress as Sir Harry"
"Bella, Burton's dog, is half-pomerian and half-chihuahua"
"Quite the singer, Burton was 3 years all region and 2 years all state"
"Despite what SPUF says, Burton does not like Snickers"
"Built his first computer when was 13"





*/

# header?

# FB timeline image
## embedded personal photo
### use Steam data, show ingame border around photo

# twitter feed (both sptonjohn and steam_support)

# scrape recent posts? (can cURL do this?) http://net.tutsplus.com/tutorials/php/how-to-syndicate-content-without-utilizing-a-news-feed/



?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>TONJOHN&trade; - Projects</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">tonjohn&trade;</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="index.php?pw=spuf">Home</a></li>
              <li class="active"><a href="#">Projects</a></li>
              <li><a href="#wishlist">Wishlist</a></li>
              <li><a href="music.php?pw=spuf">Music</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="row">
        <div class="span9">
          <div id="myCarousel" class="carousel slide">
            <!-- Carousel items -->
            <div class="carousel-inner">
              <div class="item">
                <img src="http://placekitten.com/870/500" alt="">
                <div class="carousel-caption">
                  <h4>First Thumbnail label</h4>
                  <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                </div>
              </div>
              <div class="item">
                <img src="./Template_JS_files/bootstrap-mdo-sfmoma-02.jpg" alt="">
                <div class="carousel-caption">
                  <h4>Second Thumbnail label</h4>
                  <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                </div>
              </div>
              <div class="item active">
                <img src="http://flickholdr.com/870/500" alt="">
                <div class="carousel-caption">
                  <h4>Third Thumbnail label</h4>
                  <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                </div>
              </div>
            </div>
            <!-- Carousel nav -->
            <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
            <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
          </div>
        </div>
      </div>


      <!-- Example row of columns -->
      <div class="row">
        <div class="span4">
          <h2>Heading</h2>
           <p>Donec id elit non <a href="#" rel="tooltip" title="Public facing knowledge base articles found at http://support.steampowered.com">mi porta gravida at eget</a> metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
        <div class="span4">
          <h2>Heading</h2>
           <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
       </div>
        <div class="span4">
          <h2>Heading</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
      </div>

      <div class="row">
        <div class="span12 well">
          <div class="tabbable"> <!-- Only required for left/right tabs -->
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab1" data-toggle="tab">Steam Forums</a></li>
              <li><a href="#tab2" data-toggle="tab">Steam Support</a></li>
              <li><a href="#tab3" data-toggle="tab">Steam</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab1">
                <h3>Steam Integration:</h3>
                <ul>
                  <li>Created a method for users to link their Steam account to their forum account, leveraging OpenID.</li>
                  <li>If a user has linked his profile,  a Steam profile button appears on the postbit.</li>
                  <li>While linking accounts is not required to access the forums, it is required for users who wish to participate in the trading forums. Using the Steam web APIs, we verify that users were in good standing, removing access to those who become trade banned. Trade banned status is shown to moderators and administrators. To minimize the number of requests, web api results are stored in memcache for 24 hours at a time.</li>
                  <li>All done via vBulletin’s plugin system (exception being the actual linking process).</li>
                </ul>
                <h3>Tools:</h3>
                <ul>
                  <li>Report Post thread tool option to archive reported posts.</li>
                  <li>View Profile, Search IPs, and Temp Ban buttons added to user profiles</li>
                  <li>New ModCP page to view user data in memcache and search users by SteamID</li>
                  <li>New ModCP page to view last 500 users banned for spam</li>
                  <li>IP Search modified to notify which users in the result set have been banned</li>
                  <li>Account approval page improved to flag potential bots and indicate accounts with linked SteamIDs</li>
                </uL>
                <h3>UX:</h3>
                <ul>
                  <li>Re-designed the forum UI to match the Steam Store</li>
                  <li>Improved Search dropdown by adding Google search, My Threads button, and My Posts button</li>
                  <li>Added Social media sharing buttons to the first post of a thread</li>
                </ul>
              </div>
              <div class="tab-pane" id="tab2">
                <h3>FAQ Generator:</h3>
                <p>Created a tool in C# to streamline the process of creating <a href="#" rel="tooltip" title="Public facing knowledge base articles found at http://support.steampowered.com">FAQs</a> and <a href="#" rel="tooltip" title="Pre-written respones to send to customers">Quick Texts</a>. This tool greatly reduced the numbers of clicks and steps needed while making the process accessable to those without HTML experience.</p>
                <h3>Inline Messaging:</h3>
                <p>Built a framework for displaying relevant content to users based on category and product selection during ticket submission with the goal of making users more self-sufficient and reducing ticket traffic. Use jQuery to AJAX request the appropriate HTML file to be displayed to the user.</p>
                <h3>FAQ Re-Design</h3>
                <p>After looking at metrics on incoming tickets for non-Valve games, it was clear that the information in our FAQs was not helpful and presented in a way that was confusing to users. After mocking up some changes to reduce redundancy and highlight the important content, worked with a designer develop a polished design and implement it.</p>
                <h3>Social Media</h3>
                <p>Created and maintain the <a href="http://twitter.com/#!/Steam_Support/">@Steam_Support</a> twitter account, primarily used to broadcast downtime and other widespread issues. Additionally, help maintain Valve's various facebook pages.</p>
              </div>
              <div class="tab-pane" id="tab3">
                <p>Howdy, I'm in Section 3.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <hr>

      <footer>
        <p>&copy; Burton Johnsey 2012</p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script type="text/javascript">
      $("[rel=tooltip]").tooltip();
    </script>





  </body>
</html>
