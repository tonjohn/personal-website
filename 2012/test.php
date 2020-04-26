<?php

$pw = "spuf";

$sPassword = $_GET['pw'];

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
    <title>TONJOHN&trade; - Home</title>
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
          <div class="btn-group pull-right">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-user"></i> Username
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="#">Profile</a></li>
              <li class="divider"></li>
              <li><a href="#">Sign Out</a></li>
            </ul>
          </div>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">Projects</a></li>
              <li><a href="#contact">Wishlist</a></li>
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
            <h1>About Me</h1>
            <p>&nbsp;A Texas-born, Justin Bieber look-alike, Burton jumped into gaming at an early age. Building computers, hoarding consoles, and moderating Steam forums made him quite the teen heartthrob. When his facial hair became too prominent to disguise, he jumped into a Geek Squad uniform and enrolled as a Computer Science major at Southern Methodist University.</p>
            <p>&nbsp;In 2007, Burton joined Valve as a Community Developer. He came with a signature giggle, an addiction to Snickers, and the rare ability to find a relevant song for any occasion. Now, Burton can also claim expertise in web development, anti-cheat development, and community management</p>
            <p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p>
          </div>
          <div class="row-fluid">
            <div class="span12">
              <h2>Skills:</h2>
              <span class="label label-info">PHP</span> <span class="label label-info">C++</span> <span class="label label-info">C#</span> <span class="label label-info">MySQL</span>
              <span class="label label-info">vBulletin</span> <span class="label label-info">DeskPro</span> 
              <span class="label label-info">Community Management</span> <span class="label label-info">Help Desk Support</span>
              <span class="label label-info">Web Development</span> <span class="label label-info">Anti-Cheat</span> <span class="label label-info">Anti-Piracy</span> <span class="label label-info">Hiring</span>
            </div>
          </div>
          <div class="row-fluid">
            <div class="span6">
              <h2>Anti-Cheat, Anti-Piracy Developer</h2>
              <ul class="jobDescription">
                <li>Working with fellow developers and partners to create industry leading anti-cheat and DRM products (VAC and CEG, respectively) used in games such as Valve's Left 4 Dead 2 and Activision's <a href="www.steampowered.com">Call of Duty: Black Ops</a></li>
                <li>Creating web-based tools using PHP, Javascsript, and SQL</li>
                <li>Infiltrating cheat and pirate communities, obtaining insider information</li>
                <li>Analyzing, identifying, and signaturing samples of cheats</li>
              </ul>
            </div><!--/span-->
            <div class="span6">
              <h2>Community Developer</h2>
              <ul class="jobDescription">
                <li>Managing a team of community managers and 50+ volunteer moderators</li>
                <li>Administering the Steam forums; including programming and design</li>
                <li>Improving internal and external communication; providing developers constructive feedback from
        current and potential customers</li>
                <li>Working with partners to improve customer relations and marketing</li>
              </ul>
            </div><!--/span-->
          </div><!--/row-->
          <div class="row-fluid">
            <div class="span12">
              <h2>Credited In: </h2>
              <div class="row-fluid">
                <div class="span4">
                  <span class="label"><i class="icon-chevron-right"></i> <i>Left 4 Dead</i> (2008) <br/></span>
                  <span class="label"><i class="icon-chevron-right"></i> <i>Zeno Clash</i> (2009)</span>
                </div>
                <div class="span4">
                  <span class="label"><i class="icon-chevron-right"></i> <i>Left 4 Dead 2</i> (2009) <br/></span>
                  <span class="label"><i class="icon-chevron-right"></i> <i>Alien Swarm</i> (2010)</span>
                </div>
                <div class="span4">
                  <span class="label"><i class="icon-chevron-right"></i> <i>Portal 2</i> (2011) <br/></span>
                  <span class="label"><i class="icon-chevron-right"></i> <i>Dota 2</i> (2012)</span>
                </div>
              </div>
            </div>
          </div>
          <div class="row-fluid">
            <div class="span4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
            <div class="span4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
            <div class="span4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
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
