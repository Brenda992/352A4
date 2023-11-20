<?php
include_once('function.php');

// Retrieve and assign the product code from POST data, defaulting to an empty string if not set
$productCode = !empty($_POST['productCode']) ? $_POST['productCode'] : "";

// Check if the user is not logged in
if(!isset($_SESSION['valid_user'])) {
	$_SESSION['callback_url'] = 'addtowatchlist.php';
	$_SESSION['productCode'] = $productCode;
	redirect_to('login.php');
} 

// Retrieve the email of the logged-in user
$email = $_SESSION['valid_user'];
// Check if the callback URL is set to addtowatchlist.php and update productCode from session if so
if (isset($_SESSION['callback_url']) && $_SESSION['callback_url'] == 'addtowatchlist.php') {
	$productCode = $_SESSION['productCode'];
	unset($_SESSION['callback_url'],$_SESSION['productCode']);
}

$message = "";
// Check if the product is not already in the watchlist
if (!inWatchlist($productCode)) {
	$query = "INSERT INTO watchlist (email, productCode) VALUES (?,?)";
	  
	$stmt = $db->prepare($query);
	$stmt->bind_param('ss',$email,$productCode);
	$stmt->execute();
			  
	$message = urlencode("The model has been added to your <a href=\"showwatchlist.php\">watchlist</a>.");
}
//fetch the watchlist for the user
redirect_to("modeldetails.php?productCode=$productCode&message=$message");

?>