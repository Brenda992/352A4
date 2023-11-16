<?php
include('function.php');
no_SSL();

$code = trim($_GET['productCode']);
@$msg = trim($_GET['message']);

$query_str = "SELECT * 
			  FROM products 
			  WHERE productCode = ?"; 
			  
$stmt = $db->prepare($query_str);
$stmt->bind_param('s',$code);
$stmt->execute();
$stmt->bind_result($prCode,$prName,$prLine,$prScale,$prVendor,$prDesc,$prQ,$prPrice,$MSRP);;

include('header.php');

if($stmt->fetch()) {
	echo "<h3>$prName</h3>\n";
	echo "<p>Category: $prLine, Scale: $prScale, Vendor: $prVendor, Price: \$$prPrice</p>\n";
	echo "<p>Description: $prDesc</p>\n";
	}
$stmt->free_result();

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