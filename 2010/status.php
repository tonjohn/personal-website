<?php
$bjstatus = "";
$allstatus = "";
if (isset($_POST['status']) && isset($_POST['status_all']))
{
	var_dump($_POST['status_all']);
	//$test = unserialize($_POST['status_all']);
	//var_dump($test);
	$bjstatus = $_POST['status'];
	$allstatus = $_POST['status_all'];
	//echo "<br><br>Unserilized:<br>";
	//$allstatus = unserialize($allstatus);
	var_dump($allstatus);
}
else
{
	mysql_connect("db2169.perfora.net", "dbo310388922", "pefe74SP") or die(mysql_error()); 
	mysql_select_db("db310388922") or die(mysql_error());
	$query = "SELECT status FROM status_burton ORDER BY time DESC";
	$result = mysql_query($query) or die('fail boat');
	
	list($bjstatus) = mysql_fetch_array($result);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php include("includes/head.php"); ?>

<body>

<!-- Start Header -->

<?php include("includes/header.php"); ?>

<div id="wrapper">
	<div class="contentBG">
		<!-- Left Collumn Content -->
		<div class="leftCol">
			<div class="headerBG">
				<div class="text">
		
					<h1>STATUS</h1>

				</div> <!-- close text -->
			</div> <!-- close headerBG -->

			<div class="leftBody">
				<!-- Start Main Content -->
				<hr />
				<p><a name="features"></a></p>
				<?php echo "<h2>$bjstatus</h2>"; ?>
				<hr />
				<?php 
						
				
				$x=2; // Loop control variable to limit results
				while((list($bjstatus) = mysql_fetch_array($result)) && ($x < 27))
				{
					echo "$bjstatus";
					echo "<hr />";
					$x++;
				}
				?>
				<hr />
				<a href='http://photos-h.ak.fbcdn.net/hphotos-ak-snc1/hs047.snc1/2837_573415882999_18806855_34444452_923670_n.jpg'><img src='http://photos-h.ak.fbcdn.net/hphotos-ak-snc1/hs047.snc1/2837_573415882999_18806855_34444452_923670_n.jpg' border='0'/></a>
				<hr />

				
				
			
				<!-- End Main Content -->
			</div> <!-- close leftBody -->
		</div> <!-- close leftCol -->
		<!-- End Left Collumn Content -->

		<!-- Right Collumn Content (menu) -->
		<?php include("rightcol.php"); ?>
		<!-- End Right Collumn Content -->

		<div style="width: 100%; clear: both;"></div>
	</div> <!-- close contentBG -->
</div> <!-- close wrapper -->

<!-- Start Footer -->
<?php include("footer.php"); ?>
<!-- End Footer -->

</center>
</body>
</html>