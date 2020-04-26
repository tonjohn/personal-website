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
    <title>TONJOHN&trade; - Music</title>
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
      .sidebar-nav {
        padding: 9px 0;
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
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">tonjohn&trade;</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="index.php?pw=spuf">Home</a></li>
              <li><a href="projects.php?pw=spuf">Projects</a></li>
              <li><a href="#contact">Wishlist</a></li>
              <li class="active"><a href="#">Music</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
          <blockquote>
            <p>"Your heart is alive. Keep listening to what it has to say."</p>
            <small>The Alchemist</small>
          </blockquote>
          <script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
          <script>
          new TWTR.Widget({
            version: 2,
            type: 'profile',
            rpp: 4,
            interval: 30000,
            width: 'auto',
            height: 300,
            theme: {
              shell: {
                background: '#3a87ad',
                color: '#ffffff'
              },
              tweets: {
                background: '#eeeeee',
                color: '#000000',
                links: '#00078c'
              }
            },
            features: {
              scrollbar: false,
              loop: false,
              live: true,
              behavior: 'all'
            }
          }).render().setUser('sptonjohn').start();
          </script>

        </div><!--/span-->
        <div class="span9">
          <div class="hero-unit">
            <h1>My Music</h1>
            <p>Burton grew up a choir boy, making TPSMEA All Region (3 years) and All State (2 years) in high school. In addition to choir, Burton participated in the annual school musical, landing the leading role in three of the musicals. His favorite part was Curly in Robert and Hammerstein's <i>Oklahoma!</i></p>
            <p>Tobi and Burton should have a karaoke-off. Loser buys a round of drinks and sloppy joes at Lot 3.</p>
          </div>
          <div class="row-fluid">
            <div class="span6">
              <h2>The Lord's Prayer</h2>
              <audio controls="controls">
                <source src="audio/TheLordsPrayer.ogg" />
                <source src="audio/TheLordsPrayer.mp3" />
                Your browser does not support the audio tag.
              </audio>
            </div><!--/span-->
            <div class="span6">
              <h2>Ave Maria</h2>
              <p>
                <audio autoplay="" controls="controls">
                  <source src="audio/AveMaria.ogg" />
                  <source src="audio/AveMaria.mp3" />
                  Your browser does not support the audio tag.
                </audio>
              </p>
            </div><!--/span-->
          </div><!--/row-->
        </div><!--/span-->
        <div class="span1">
         
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Burton Johnsey 2012</p>
        <P><small>"Burton has two speeds: stopped, and not started yet." -- Mike Blaszczak</small></p>
        
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>

  </body>
</html>
