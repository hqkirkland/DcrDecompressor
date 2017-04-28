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
	
	
	$birthDate = $user->getData("birthday");
	$birthDate = explode("-", $birthDate);
	
	// Get age from date or birthdate
	$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md")
	? ((date("Y") - $birthDate[0]) - 1)
	: (date("Y") - $birthDate[0]));
	
	if($user->getData("gender") == "F")
	{
		$gender = 1;
	}
	
	else
	{
		$gender = 2;
	}
	
	?>

<account>
	<birthday><?php echo $user->getData("birthday"); ?></birthday>
	<age><?php echo $age; ?></age>
	<nsid><?php echo $_SESSION["username"]; ?>3264</nsid>
	<country><?php echo $user->getData("country"); ?></country>
	<continent>North America</continent>
	<cannedtalk><?php echo $user->getData("safechat"); ?></cannedtalk>
	<paying>true</paying>
</account>
<avatar>
	<name><?php echo $_SESSION["username"]; ?></name>
	<appearance><?php echo $user->getData("appearance"); ?></appearance>
	<gender><?php echo $gender ?></gender>
	<gamemoney>100000</gamemoney>
</avatar>
<inventory>
<?php

	$id = $user->getData("id");
	$itemResult = $mysqli->query("SELECT * FROM user_items WHERE user_id = '{$id}'");

	while($item = $itemResult->fetch_assoc())
	{
		echo '<item id="' . $item["item_id"] . '" color="' . $item["color_id"] . '"/>
		';
	}
		
	?>
</inventory>
<friends>
	<?php

		$id = $user->getData("id");
		
		$friendshipResult = $mysqli->query("SELECT * FROM user_friendships WHERE (friend_a = '{$id}' OR friend_b = '{$id}') AND (is_request = '0')");
		
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
			
			$friendResult = $mysqli->query("SELECT username, gender, is_online FROM users WHERE id = '{$fid}'");
			
			while($friend = $friendResult->fetch_assoc())
			{
				if($friend["gender"] == "M")
				{
					$gender = 2;
				}
				
				else
				{
					$gender = 1;
				}
				
				if($friend["is_online"] == "1")
				{
					$online = "true";
				}
				
				else
				{
					$online = "false";
				}
				
				echo '	<friend name="' . $friend["username"] . '" gender="'. $gender . '" server="null" online="'. $online . '" />
				';
			}
		}

		?>
</friends>
<quests></quests>