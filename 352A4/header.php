<html>

<head>
	<title>Classic Models</title>
	<style>
		a.nav {
			color: white;
			text-decoration: none;
		}

		li a.action {
			text-decoration: none;
			font-size: 70%
		}
		.center {
			text-align: center;
		}
	</style>

</head>

<body>
	<table style="width:100%;border-spacing:0px">
		<tr height="30" style='background-color:grey;'>
			<td class="center" style="font-family: sans-serif; font-size:24px;color:white;">
				<strong><a class="nav" href="showmodels.php">All Models</a> |
					<a class="nav" href="showwatchlist.php">Watchlist</a> |
					<?php
					if (isset($_SESSION['valid_user']))
						echo "<a class=\"nav\"  href=\"logout.php\">Logout</a>";
					else
						echo "<a class=\"nav\" href=\"login.php\">Login</a>";
					?>
			</td>
		<tr style="background-color:FFFFFF;">
			<td>
