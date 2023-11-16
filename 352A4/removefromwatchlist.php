<?php
include_once('function.php');

$message = "";
if (!empty($_GET['productCode']) && !empty($_SESSION['valid_user'])) {
	$query = "DELETE FROM watchlist WHERE email=? AND productCode =?";
	  
	$stmt = $db->prepare($query);
	$stmt->bind_param('ss',$_SESSION['valid_user'],$_GET['productCode']);
	$stmt->execute();
			  
	$message = urlencode("The model has been removed from to your <a href=\"showwatchlist.php\">watchlist</a>.");
}
//fetch the watchlist for the user
redirect_to("showwatchlist.php");
?>