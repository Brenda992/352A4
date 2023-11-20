<?php
include_once('function.php');

$message = "";
// Check if productCode is set in GET request and if the user is logged in
if (!empty($_GET['productCode']) && !empty($_SESSION['valid_user'])) {
	// Prepare a query to delete the specified product from the user's watchlist
	$query = "DELETE FROM watchlist WHERE email=? AND productCode =?";
	  
	$stmt = $db->prepare($query);
	$stmt->bind_param('ss',$_SESSION['valid_user'],$_GET['productCode']);
	$stmt->execute();
			  
	$message = urlencode("The model has been removed from to your <a href=\"showwatchlist.php\">watchlist</a>.");
}
//fetch the watchlist for the user
redirect_to("showwatchlist.php");
?>