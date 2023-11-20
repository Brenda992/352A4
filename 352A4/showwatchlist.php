<?php
include_once('function.php');
no_SSL();

// Check if the user is not logged in
if(!isset($_SESSION['valid_user'])) {
	$_SESSION['callback_url'] = 'showwatchlist.php';
	redirect_to('login.php');
} 

// Get the email of the currently logged-in user
$email = $_SESSION['valid_user'];
// Clear the callback URL if it is set to showwatchlist.php
if (isset($_SESSION['callback_url']) && $_SESSION['callback_url'] == 'showwatchlist.php') {
	unset($_SESSION['callback_url']);
}

$query_str = "SELECT P.productCode, P.productName ";
$query_str .= "FROM products P INNER JOIN watchlist W ON P.productCode = W.productCode ";
$query_str .= "WHERE W.email='$email'";
$res = $db->query($query_str);

// Function to create a clickable link for each product model
function format_model_name_as_link($id,$name,$page) {
	echo "<a href=\"$page?productCode=$id\">$name</a>";
	}

// Function to create a clickable action link (e.g., for removing items from the watchlist)
function format_watchlist_action_link($id,$name,$page) {
	echo "<a class=\"action\" href=\"$page?productCode=$id\">$name</a>";
	}

include_once('header.php');

// Display any message if it is set
if (isset($message)) echo "<p>$message</p>";

echo "<h2>Your Watchlist</h2>";
echo "<ul>";
// Iterate through each row in the query result
while ($row = $res->fetch_row()) {
	echo "<li>";
	format_model_name_as_link($row[0], $row[1],"modeldetails.php");
	echo " ";
	format_watchlist_action_link($row[0],"Remove","removefromwatchlist.php");
	echo "</li>\n";
};
echo "</ul>";

echo "<p id=\"msg\"></p>";
include_once('footer.php');

$res->free_result();
$db->close();
?>

