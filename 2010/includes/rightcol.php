<?php 

$features_class = 'rightMenuSubLink';
$signup_class = 'rightMenuSubLink';
$overview_class = 'rightMenuLink';
$directory_class = 'rightMenuLink';

$script_name = str_replace('/', '', $_SERVER['SCRIPT_NAME']);

if ($script_name == 'index.php' || $script_name == NULL){
	$overview_class = 'rightMenuSelected';
}
if ($script_name == 'cheater.php'){
	$features_class = 'rightMenuSubSelected';
}
if ($script_name == 'cheat.php'){
	$signup_class = 'rightMenuSubSelected';
}
if ($script_name == 'directory.php'){
	$directory_class = 'rightMenuSelected';
}



?>

<div class="rightCol">
		<div class="rightHR"></div>
		<a class="rightMenuLink" href="index.php">ABOUT ME</a>

			<div class="rightHR"></div>		
			<a class="rightMenuSubLink" href="index.php#experience">Experience</a>
			<div class="rightHR"></div>		
			<a class="rightMenuSubLink" href="index.php#education">Education</a>
			<div class="rightHR"></div>		
			<a class="rightMenuSubLink" href="recommendations.php">Recommendations</a>
		
		<div class="rightHR"></div>
		<a class="rightMenuLink" href="status.php">MY STATUS</a>
		
		<div class="rightHR"></div>
		<a class="rightMenuLink" href="links.php">LINKS</a>
			<div class="rightHR"></div>		
			<a class="rightMenuSubLink" href="http://www.mobygames.com/developer/sheet/view/developerId,348975/">@ MobyGames</a>
			<div class="rightHR"></div>		
			<a class="rightMenuSubLink" href="http://www.linkedin.com/in/bjohnsey">@ LinkedIn</a>
		
		<div class="rightHR"></div>		
		<a class="rightMenuLink" href="http://www.intheLYMElight.net">intheLYMElight</a>
			
		

</div>


