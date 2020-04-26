<?php

require_once 'facebook/php/facebook.php';
$appapikey = 'af18f466c42fcb2ac6dafaaf343004b2';
$appsecret = '6b5529797e4a1325b80467643750b982';
$facebook = new Facebook($appapikey, $appsecret);
$user_id = $facebook->require_login();
$burton_id = 18806855;

$query = "SELECT time, message FROM status WHERE uid=$burton_id LIMIT 30";     //(see above examples)
$result = $facebook->api_client->fql_query($query);
var_dump($result);
if ($result != NULL)
{
	$bjstatus = $result[0]['message'];
	
	$array_status = array_slice($result, 1, 26);
	var_dump($array_status);
	echo "<br><br><br>";
	$i = 0;
	$allmess = '';
	foreach ($array_status as $status => $message)
	{
		$allmess[$i] = $message['message'];
		$i++;
	}
	
	//var_dump($allmess);
	
	echo "Burton's status:<br>";
	echo "$bjstatus";
	
	

	if (isset($_GET['update']))
	{
		mysql_connect("db2169.perfora.net", "dbo310388922", "pefe74SP") or die(mysql_error()); 
		mysql_select_db("db310388922") or die(mysql_error());
	
		$i = 0;
		while ($i < 25)
		{
		
			$dbstatus = $array_status[$i]['message'];
			$query = "SELECT '1' FROM 'status_burton WHERE status='At the crab pot'";
			$dupe_result = mysql_query($query); //Is file a duplicate?
			//$dupe_result = mysql_fetch_array($dupe_result);
			//$dupe_result_var = mysql_num_rows($dupe_result);
			var_dump($dupe_result);
			
			
			
			echo "$dbstatus <br>";
			
			
			
			/*if( $hash_result_var > 0 )
			{
				$query = "INSERT INTO status_burton (status) ". 
						"VALUES ('$dbstatus')";
				$result=MYSQL_QUERY($query) or die('Database Error');
			}*/
			
			
			
			
			
			$i++;
		} 
	}
	
	
	$query = "SELECT pid FROM photo_tag WHERE subject=$burton_id";
	$result = $facebook->api_client->fql_query($query);
	//list($pid) = mysql_fetch_array($result);
	//$pid = $facebook->api_client->fql_query($query);
	echo "<br><br><br>";
	
	
	$pid = $result[0]['pid'];
	//var_dump($pid);
	
	echo "<br><br><br>";
	
	$query = "SELECT src_big FROM photo WHERE pid='$pid'";
	$result = $facebook->api_client->fql_query($query);
	//list($img_src) = mysql_fetch_array($result);
	//$img_src = $facebook->api_client->fql_query($query);
	
	$img_src = $result[0]['src_big'];
	
	//var_dump($img_src);
	
	echo "<br><br><br>";
	
	echo "<a href='$img_src'><img src='$img_src' border='0'/></a>";
}	
	
	
	
	





?>