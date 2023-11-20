<?php
include('function.php');
no_SSL();

// Retrieve and trim the product code from the GET request
$code = trim($_GET['productCode']);
// Retrieve and trim any message passed in the GET request, using @ to suppress errors if 'message' is not set
@$msg = trim($_GET['message']);

$query_str = "SELECT * 
			  FROM products 
			  WHERE productCode = ?"; 
			  
$stmt = $db->prepare($query_str);
$stmt->bind_param('s',$code);
$stmt->execute();
$stmt->bind_result($prCode,$prName,$prLine,$prScale,$prVendor,$prDesc,$prQ,$prPrice,$MSRP);;

include('header.php');

// Fetch the result and display product details
if($stmt->fetch()) {
	echo "<h3>$prName</h3>\n";
	echo "<p>Category: $prLine, Scale: $prScale, Vendor: $prVendor, Price: \$$prPrice</p>\n";
	echo "<p>Description: $prDesc</p>\n";
	}
$stmt->free_result();

// Display add to watchlist form if the user is logged in and the product is not already in the watchlist
if(loggedIn() && !inWatchlist($code) ) {
	echo "<form action=\"addtowatchlist.php\" method=\"post\">\n";
	echo "<input type=\"hidden\" name=\"productCode\" value=$code>\n";
	echo "<input type=\"submit\" value=\"Add To Watchlist\">\n";
	echo "</form>\n";
} else if (!empty($msg) ) {
	echo "<p>$msg</p>\n";
} else if (loggedIn()) {
	echo "This model is already in your <a href=\"showwatchlist.php\">watchlist</a>.";
}

include('footer.php');
$db->close();
?>