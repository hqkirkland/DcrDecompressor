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
	
	require_once("./../global.php");
	
	/*
	if(isset($_GET["createBots"]))
	{
		for($i = 1; $i < 101; $i++)
		{
			$num = "";

			if ($i < 10)
			{
				$num = "00";
			}

			if ($i > 9 && $i < 100)
			{
				$num = "0";
			}

			$user->registerUser("BOT".$num.$i, '1,2;67,2;94,2;44,15;51,3;34,5;24,5;72,9;61,15', '05', '05', '02', "x", "Botland", "null", 'M', "x", "playdo");
		}
	}

	exit;

	*/
	
	if (isset($_POST["username"]))
	{
		if ($user->registerUser($_POST["username"], $_POST["appearance"], $_POST["birtday"], $_POST["birthmonth"], $_POST["birthyear"], $_POST["checksum"], $_POST["country"], $_POST["email"], $_POST["gender"], $_POST["password"], $_POST["thumb"]))
		{
			echo "ok";
			$user->signIn($_POST["username"], $_POST["password"]);
		}
	}
	
	?>