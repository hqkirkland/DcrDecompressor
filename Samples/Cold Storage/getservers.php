<?php

/*
														 
		___       ______       ________  ___  __  ______ 
		__ |     / /__(_)____________/ / __ \/ / / / __ \
		__ | /| / /__  /__  __ \  __  / /_/ / /_/ / /_/ /
		__ |/ |/ / _  / _  / / / /_/ / ____/ __  / ____/ 
		____/|__/  /_/  /_/ /_/\__,_/_/   /_/ /_/_/      
		
														  
	Copyright (C) 2016 
	written_by::programmer("hunter_kirkland");
	
	Released under GPL License v3 (See License.txt)

	If you change this program, you absolutely _MUST_ release
	these changes even if under a new name, /and/ retain credits.
	
	*/
	
	// ===================
	/*  Whirlpool Edition */
	// ===================
	
	require_once("../global.php");
	$availableArray = mysqli_fetch_array($mysqli->query("SELECT available FROM `server_status`"));
	
	if($availableArray[0] == '0')
	{
		echo "0.0.0.0 0 0 GAME OFFLINE";
		exit();
	}
	
	$onlineCount = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM `users` WHERE is_online = '1'"));
	$onlineCount = $onlineCount[0];

	$onlineCount = round($onlineCount / 3, 0, PHP_ROUND_HALF_UP);
	
	$id = $user->getData("id");
	
	if($id = "")
	{
		$hasFriends = "0";
	}
		
	$friendshipResult = $mysqli->query("SELECT * FROM user_friendships WHERE (friend_a OR friend_b = '{$id}') AND (is_request = '0')");
	$hasFriends = "0";
	
	while($friendship = $friendshipResult->fetch_assoc())
	{
		if($friendship["friend_a"] == $id)
		{
			$fid = $friendship["friend_b"];
		}
		
		else
		{
			$fid = $friendship["friend_a"];
		}
		

		$friendResult = $mysqli->query("SELECT is_online FROM users WHERE id = '{$fid}'");
		
		while($friend = $friendResult->fetch_assoc())
		{
			if($friend["is_online"] == "1")
			{
				$hasFriends = '1';
			}
		}	
	}

?>
23.112.36.245 <?php echo $onlineCount; ?> <?php echo $hasFriends; ?> Royal Cloud Empire
<?php if($_SERVER["HTTP_CF_CONNECTING_IP"] == "23.112.36.245") { echo "192.168.1.74 " . $onlineCount . " " . $hasFriends . " Airspring Domain"; } ?>
